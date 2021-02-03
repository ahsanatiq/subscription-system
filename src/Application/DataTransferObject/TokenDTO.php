<?php

namespace Application\DataTransferObject;

use Illuminate\Http\Request;
use Spatie\DataTransferObject\DataTransferObject;

class TokenDTO extends DataTransferObject
{
    /** string */
    public $client_token;

    public static function fromRequest(Request $request)
    {
        return new self([
            'client_token' => $request['clientToken'],
        ]);
    }
}
