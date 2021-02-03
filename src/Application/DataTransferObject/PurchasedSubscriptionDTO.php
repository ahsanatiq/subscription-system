<?php

namespace Application\DataTransferObject;

use Illuminate\Http\Request;
use Spatie\DataTransferObject\DataTransferObject;

class PurchasedSubscriptionDTO extends DataTransferObject
{
    /** string */
    public $client_token;

    /** string */
    public $receipt;

    public static function fromRequest(Request $request)
    {
        return new self([
            'client_token' => $request['clientToken'],
            'receipt' => $request['receipt'],
        ]);
    }
}
