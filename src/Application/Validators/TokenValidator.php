<?php
namespace Application\Validators;

class TokenValidator extends BaseValidator
{
    public $rules = [
        'client_token'=> ['required', 'string'],
    ];
    public $attributes = [
        'client_token'=> 'clientToken',
    ];

    public function sanitize($data)
    {
        if (!empty($data->client_token)) {
            $data->client_token = (string) $data->client_token;
        }

        return $data;
    }
}
