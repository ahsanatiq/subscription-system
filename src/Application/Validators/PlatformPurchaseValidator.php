<?php
namespace Application\Validators;

class PlatformPurchaseValidator extends BaseValidator
{
    public $rules = [
        'receipt'=> ['required', 'string'],
    ];

    public function sanitize($data)
    {
        if (!empty($data->receipt)) {
            $data->receipt = (string) $data->receipt;
        }

        return $data;
    }
}
