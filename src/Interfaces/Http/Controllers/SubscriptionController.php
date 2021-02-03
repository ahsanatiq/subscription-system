<?php

namespace Interfaces\Http\Controllers;

use Illuminate\Http\Request;
use Application\CheckSubscription;
use Application\PurchasedSubscription;
use Application\DataTransferObject\PurchasedSubscriptionDTO;
use Application\DataTransferObject\TokenDTO;

class SubscriptionController extends Controller
{

    public function purchase(Request $request, PurchasedSubscription $app)
    {
        $dto = PurchasedSubscriptionDTO::fromRequest($request);
        $status = $app->execute($dto);
        return response()->json(['success' => $status]);
    }

    public function check(Request $request, CheckSubscription $app)
    {
        $dto = TokenDTO::fromRequest($request);
        $status = $app->execute($dto);
        return response()->json(['status' => $status]);
    }
}
