<?php

namespace Interfaces\Http\Controllers;

use Illuminate\Http\Request;
use Application\RegisterDevice;
use Application\DataTransferObject\DeviceDTO;

class DeviceController extends Controller
{
    private $registerDevice;

    public function __construct(RegisterDevice $app)
    {
        $this->registerDevice = $app;
    }

    public function register(Request $request)
    {
        $dto = DeviceDTO::fromRequest($request);
        $token = $this->registerDevice->execute($dto);
        return response()->json(['token' => $token]);
    }
}
