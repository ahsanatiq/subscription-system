<?php
namespace Application\Validators;

class PurchasedSubscriptionValidator extends BaseValidator
{
    public $rules = [
        'client_token'=> ['required', 'string'],
        'receipt'=> ['required', 'string'],
    ];
    public $attributes = [
        'client_token'=> 'clientToken',
    ];

    public function sanitize($data)
    {
        if (!empty($data->client_token)) {
            $data->client_token = (string) $data->client_token;
        }
        if (!empty($data->receipt)) {
            $data->receipt = (string) $data->receipt;
        }

        return $data;
    }
}
