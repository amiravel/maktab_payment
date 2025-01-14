<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Shetabit\Multipay\Exceptions\InvalidPaymentException;
use Illuminate\Support\Str;


class VerifyController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @return mixed
     */
    public function __invoke(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'payment_id' => 'required|integer|exists:payments,id'
        ]);

        if ($validate->fails()) {
            return view('verify.failed')
                ->with('message', 'خطا در ورودی اطلاعات');
        }

        $payment_id = $request->get('payment_id');
        $payment = Payment::findOrFail($payment_id);

        if (in_array($payment->mobile, [
                "09124101910",
                "09302631762",
                "09228131017",
                "09217547569",
                "09361427265",
                "09021163695",
                "09808080800",
                "09122342323",
                "09999999999",
                "09999999998",
                "09999999997",
                "09999999996",
                "09999999995",
                "09999999994",
                "09999999993",
                "09999999992",
                "09999999991",
                "09999999990",
		"09999999992",
		"09999999989",
"09999999988",
"09999999987",
"09999999986",
"09999999985",
"09999999984",
"09999999983",
"09999999982",
"09999999981",
"09999999980",
            ]) && $payment->drive_id == 8) {
            config()->set('payment.drivers.zarinpal.mode', 'sandbox');
            config()->set('payment.drivers.zarinpal.merchantId', config()->get('payment.drivers.zarinpal.sandboxMerchantId'));
        }

        try {
            $receipt = \Shetabit\Payment\Facade\Payment::via($payment->drive->value)
                ->amount(($payment->drive->value == 'vandar' || $payment->drive->value == 'pasargad') ? ($payment->amount * 10) : $payment->amount)
                ->transactionId($payment->logs()->first()->authority)
                ->verify();

            $payment->logs()->updateOrCreate([
                'authority' => $payment->logs()->first()->authority,
                'refID' => $receipt->getReferenceId(),
            ], [
                'status' => 100,
                'type' => 'after',
                'authority' => $payment->logs()->first()->authority,
                'message' => 'پرداخت با موفقیت انجام شد.',
                'refID' => $receipt->getReferenceId(),
                'raw_receipt' => $receipt->getDetails() ?? []
            ]);

            return view('verify.success')
                ->with('payment', $payment);
        } catch (InvalidPaymentException $exception) {
            $payment->logs()->updateOrCreate([
                'status' => $exception->getCode(),
                'type' => 'after',
                'authority' => $payment->logs()->first()->authority,
            ], [
                'status' => $exception->getCode(),
                'type' => 'after',
                'authority' => $payment->logs()->first()->authority,
                'message' => $exception->getMessage(),
            ]);

            return view('verify.failed')
                ->with('payment', $payment)
                ->with('message', $exception->getMessage());
        }
    }
}
