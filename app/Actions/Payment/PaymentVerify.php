<?php


namespace App\Actions\Payment;


use App\Models\Payment;
use App\Models\PaymentLog;
use Lorisleiva\Actions\Concerns\AsAction;
use Shetabit\Multipay\Exceptions\InvalidPaymentException;

class PaymentVerify
{
    use AsAction;

    public function handle(Payment $payment)
    {
        try {
            $receipt = \Shetabit\Payment\Facade\Payment::via($payment->drive->value)
                ->amount(($payment->drive->value == 'pasargad') ? ($payment->amount * 10) : $payment->amount)
                ->transactionId($payment->logs()->first()->authority)
                ->verify();

            info($receipt);

            PaymentLog::withoutEvents(function () use ($payment, $receipt) {
                $payment->logs()->create([
                    'status' => 100,
                    'type' => 'after',
                    'authority' => $payment->logs()->first()->authority,
                    'message' => 'پرداخت با موفقیت انجام شده است.',
                    'refID' => $receipt->getReferenceId(),
                ]);
            });
        } catch (InvalidPaymentException $exception) {

            info($exception);

            PaymentLog::withoutEvents(function () use ($payment, $exception) {
                $payment->logs()->create([
                    'status' => $exception->getCode(),
                    'type' => 'after',
                    'authority' => $payment->logs()->first()->authority,
                    'message' => $exception->getMessage(),
                    'refID' => $payment->refID
                ]);
            });
        }
    }
}
