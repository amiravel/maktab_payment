<?php

namespace App\Observers;

use App\Actions\CallExtraCallback;
use App\Models\PaymentLog;
use App\Notifications\InvoicePaid;

class PaymentLogObserver
{
    /**
     * Handle the PaymentLog "created" event.
     *
     * @param \App\Models\PaymentLog $paymentLog
     * @return void
     */
    public function created(PaymentLog $paymentLog)
    {
        $payment = $paymentLog->payment;

        CallExtraCallback::dispatchIf(!is_null($payment->extra_callback), $payment);

        if ($payment->status('successful')) {
            $paymentLog->notify(new InvoicePaid($paymentLog));
        }
    }

        /**
     * Handle the PaymentLog "created" event.
     *
     * @param \App\Models\PaymentLog $paymentLog
     * @return void
     */
    public function updated(PaymentLog $paymentLog)
    {
        $payment = $paymentLog->payment;

        CallExtraCallback::dispatchIf(!is_null($payment->extra_callback), $payment);

        if ($payment->status('successful')) {
            $paymentLog->notify(new InvoicePaid($paymentLog));
        }
    }
}
