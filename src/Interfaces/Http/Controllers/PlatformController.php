<?php

namespace Interfaces\Http\Controllers;

use Domain\OS;
use Carbon\Carbon;
use Carbon\CarbonTimeZone;
use Illuminate\Http\Request;
use Interfaces\Exceptions\PlatformCredentialsFail;
use Interfaces\Exceptions\OperatingSystemNotExists;
use Application\Validators\PlatformPurchaseValidator;

class PlatformController extends Controller
{
    private $platformPurchaseValidator;

    public function __construct(PlatformPurchaseValidator $validator)
    {
        $this->platformPurchaseValidator = $validator;
    }

    public function purchase(Request $request, $os)
    {
        $data = $this->platformPurchaseValidator->sanitize($request->all());
        $this->platformPurchaseValidator->validate($data);

        if ($os == OS::APPLE_PLATFORM) {
            $datetime = Carbon::now()->tz(CarbonTimeZone::create(OS::APPLE_PLATFORM_TIMEZONE));
        } elseif ($os == OS::GOOGLE_PLATFORM) {
            $datetime = Carbon::now()->tz(CarbonTimeZone::create(OS::GOOGLE_PLATFORM_TIMEZONE));
        } else {
            throw new OperatingSystemNotExists;
        }

        $row = OS::where('name', $os)->first();
        if (!($row->test_username == $request->header('username')
            && $row->test_password == $request->header('password') )
        ) {
            throw new PlatformCredentialsFail;
        }

        $lastChar = (int) substr($data['receipt'], -1);
        $status = $lastChar % 2 == 0 ? false : true;
        $expiry = $status ? $datetime->addDays(rand(1, 365))->format(OS::PLATFORM_DATETIME_FORMAT) : null;

        return response()->json(['success' => $status, 'expiry' => $expiry]);
    }
}
