<?php

namespace Application;

use Domain\OS;
use Carbon\Carbon;
use Firebase\JWT\JWT;
use GuzzleHttp\Client;
use Domain\Subscription;
use Application\Validators\TokenValidator;
use Application\DataTransferObject\TokenDTO;
use Interfaces\Exceptions\OSEndpointFailure;
use Interfaces\Exceptions\InvalidJwtTokenException;
use Interfaces\Exceptions\OperatingSystemNotExists;
use Interfaces\Exceptions\SubscriptionAlreadyActive;
use Application\DataTransferObject\CheckSubscriptionDTO;
use Application\Validators\PurchasedSubscriptionValidator;
use Application\DataTransferObject\PurchasedSubscriptionDTO;

class CheckSubscription
{
    private $tokenValidator;
    private $decodeToken;

    public function __construct(TokenValidator $validator, DecodeToken $decodeToken)
    {
        $this->tokenValidator = $validator;
        $this->decodeToken = $decodeToken;
    }

    public function execute(TokenDTO $dto)
    {
        $dto = $this->tokenValidator->sanitize($dto);
        $this->tokenValidator->validate($dto);

        $payload = $this->decodeToken->execute($dto);

        $cache = app('redis')->get('Subscription:Expiry:'.$payload->id);
        if (!$cache) {
            $subscription = Subscription::where('devices_id', $payload->id)->first();
            if ($subscription) {
                $cache = $subscription->expiry->timestamp;
                app('redis')->set('Subscription:Expiry:'.$subscription->devices_id, $cache);
            }
        }
        if ($cache && Carbon::createFromTimestamp($cache) >= Carbon::now()) {
            return true;
        }

        return false;
    }
}
