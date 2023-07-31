<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Services\Payment\PaymentService;
// use App\Http\Services\Payment\PaymentService;
use App\Models\OnliePayment;
use App\Models\Order;
use Illuminate\Http\Request;
// use App\Models\OnliePayment;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{


    public function paymentSubmit(Request $request, PaymentService $paymentService)
    {


        $order = Order::where('user_id', $request->id)->first();
        // اینجا رو حواست باشه باید چیکار کنی


        $cash_receiver = null;

        $paymented = OnliePayment::create([
            'amount' => $request->price,
            'user_id' => $request->id,
            'pay_date' => now(),
            'cash_receiver' => $cash_receiver,
            'status' => 1,
        ]);
        $paymentService->zarinpal($request->price, $order, $paymented);
    }
}
