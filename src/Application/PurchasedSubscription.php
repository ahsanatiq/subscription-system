<?php

namespace Application;

use Domain\OS;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Domain\Subscription;
use Interfaces\Exceptions\OSEndpointFailure;
use Interfaces\Exceptions\OperatingSystemNotExists;
use Interfaces\Exceptions\SubscriptionAlreadyActive;
use Application\Validators\PurchasedSubscriptionValidator;
use Application\DataTransferObject\PurchasedSubscriptionDTO;
use Application\DataTransferObject\TokenDTO;

class PurchasedSubscription
{
    private $purchasedSubscriptionValidator;
    private $decodeToken;
    private $checkSubscription;

    public function __construct(
        PurchasedSubscriptionValidator $validator,
        DecodeToken $decodeToken,
        CheckSubscription $checkSubscription
    ) {
        $this->purchasedSubscriptionValidator = $validator;
        $this->decodeToken = $decodeToken;
        $this->checkSubscription = $checkSubscription;
    }

    public function execute(PurchasedSubscriptionDTO $dto)
    {
        $dto = $this->purchasedSubscriptionValidator->sanitize($dto);
        $this->purchasedSubscriptionValidator->validate($dto);
        $tokenDTO = new TokenDTO(['client_token'=> $dto->client_token]);

        $checkedResult = $this->checkSubscription->execute($tokenDTO);
        if ($checkedResult) {
            throw new SubscriptionAlreadyActive;
        }

        $payload = $this->decodeToken->execute($tokenDTO);

        $os = OS::where('name', $payload->os)->first();
        if (!$os) {
            throw new OperatingSystemNotExists;
        }
        $endpointInfo = config('app.env') == 'production'
            ? [$os->prod_endpoint, $os->prod_username, $os->prod_password]
            : [$os->test_endpoint, $os->test_username, $os->test_password];
        $client = new Client();
        $response = $client->request('POST', $endpointInfo[0], [
            'headers' => [
                'username' => $endpointInfo[1],
                'password' => $endpointInfo[2],
            ],
            'form_params' => [
                'receipt' => $dto->receipt
            ]
        ]);
        if ($response->getStatusCode() != 200) {
            throw new OSEndpointFailure('os endpoint "'.$os->name.'" did not return expected response');
        }
        $responseJson = json_decode($response->getBody()->getContents(), true);
        $success = $responseJson && isset($responseJson['success']) ? $responseJson['success'] : false;
        $expiry = $responseJson && isset($responseJson['expiry']) ? $os->handleDateTime($responseJson['expiry']) : '';
        if ($success && $expiry >= Carbon::now()) {
            $subscription = Subscription::updateOrCreate(['devices_id' => $payload->id], [
                'status' => 'active',
                'expiry' => $expiry
            ]);
            app('redis')->set('Subscription:Expiry:'.$subscription->devices_id, $subscription->expiry->timestamp);

            return true;
        }

        return false;
    }
}
