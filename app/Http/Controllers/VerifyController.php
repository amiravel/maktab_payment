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

        if (in_array($payment->mobile, ["09124101910", "09302631762", "09228131017", "09217547569"]) && $payment->drive_id == 8) {
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
                'status' => config()->get('payment.drivers.zarinpal.mode') === 'sandbox' ? -9 : 100,
                'type' => 'after',
                'authority' => $payment->logs()->first()->authority,
                'message' => config()->get('payment.drivers.zarinpal.mode') === 'sandbox' ? 'sandbox' : 'پرداخت با موفقیت انجام شد.',
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
