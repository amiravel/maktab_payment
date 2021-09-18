<?php

namespace App\Observers;

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

        if ($payment->status('successful')) {
            if ($payment->mobile->isOfCountry('IR')) {
                $paymentLog->notify(new InvoicePaid($paymentLog));
            }
        }
    }
}
