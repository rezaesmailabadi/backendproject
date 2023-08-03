<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Services\Payment\PaymentService;
// use App\Http\Services\Payment\PaymentService;
use App\Models\OnliePayment;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Models\User;
use Shetabit\Multipay\Invoice;
use Shetabit\Multipay\Exceptions\InvalidPaymentException;
use Shetabit\Payment\Facade\Payment as PaymentBack;

// use App\Models\OnliePayment;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{

    public function getUser($token)
    {
        $user = User::where('token', $token)->first();
        if (!$user) {
            return abort(401);
        }
        return $user;
    }

    public function paymentSubmit(Request $request, PaymentService $paymentService)
    {
        $user = $this->getUser($request->id);
        $order = Order::where('user_id', $user->id)->first();

        $price = (int)$request->price;

        // Create new invoice.
        $invoice = (new Invoice)->amount($price);

        // paymentUrl
        $paymentUrl = PaymentBack::callbackUrl(route('paymentVerify'))->purchase($invoice, function ($driver, $transactionId) use ($request, $user, $price) {
            $cash_receiver = null;
            $paymented = OnliePayment::create([
                'amount' => $price,
                'user_id' => $user->id,
                'transaction_id' => (string)$transactionId,
            ]);
        })->pay()->toJson();
        $paymentUrl = json_decode($paymentUrl, false, 512, JSON_THROW_ON_ERROR);

        // return
        return response()->json([
            'url' => $paymentUrl->action
        ]);
    }

    public function paymentVerify(Request $request)
    {
        if ($request->filled('Status') && $request->filled('Authority')) {
            $payment = OnliePayment::where('transaction_id', $request->get('Authority'))->where('status_bank', '!=', 100);
            if ($payment) {
                try {
                    $paymentItem = $payment->firstOrFail();
                    $receipt = PaymentBack::amount((int)$paymentItem->amount)->transactionId($paymentItem->transaction_id)->verify();
                    $payment->update([
                        'status' => 1,
                        'status_bank' => 100,
                    ]);
                } catch (InvalidPaymentException $exception) {
                    $payment->update([
                        'status_bank' => $exception->getCode(),
                    ]);
                }
                return redirect()->to('http://localhost:3000/');
            } else {
                return redirect()->route(404);
            }
        }
    }
}
