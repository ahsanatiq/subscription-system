<?php

namespace Application;

use Carbon\Carbon;
use Domain\Device;
use Firebase\JWT\JWT;
use Illuminate\Support\Facades\Log;
use Application\Validators\DeviceValidator;
use Application\DataTransferObject\DeviceDTO;

class RegisterDevice
{
    private $deviceValidator;

    public function __construct(DeviceValidator $validator)
    {
        $this->deviceValidator = $validator;
    }

    public function execute(DeviceDTO $dto)
    {
        $dto = $this->deviceValidator->sanitize($dto);
        $this->deviceValidator->validate($dto);

        $device = Device::firstOrCreate([
            'u_id' => $dto->u_id,
            'app_id' => $dto->app_id,
            'os' => $dto->os,
            'lang' => $dto->lang,
        ]);

        $token = JWT::encode(array_merge($device->only('id', 'u_id', 'app_id', 'lang', 'os'), [
            'iat' => Carbon::now()->timestamp,
            'exp' => Carbon::now()->addMinutes(config('jwt.ttl_minutes'))->timestamp,
            'rnd' => rand()
        ]), config('jwt.secret'), 'HS256');

        return $token;
    }
}
