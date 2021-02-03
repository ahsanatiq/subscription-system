<?php

namespace Application\DataTransferObject;

use Illuminate\Http\Request;
use Spatie\DataTransferObject\DataTransferObject;

class DeviceDTO extends DataTransferObject
{
    /** string */
    public $u_id;

    /** string */
    public $app_id;

    /** string */
    public $lang;

    /** string */
    public $os;

    public static function fromRequest(Request $request)
    {
        return new self([
            'u_id' => $request['uID'],
            'app_id' => $request['appID'],
            'lang' => $request['language'],
            'os' => $request['os'],
        ]);
    }
}
