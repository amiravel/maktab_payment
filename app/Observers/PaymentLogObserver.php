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
        // TODO: changed to dynamic tags id
        if ($paymentLog->payment->tags()->whereIn('id', [131, 134])->exists())
            if ($paymentLog->payment->status('successful') && $paymentLog->payment->mobile->isOfCountry('IR')) {
                $paymentLog->notify(new InvoicePaid($paymentLog));
            }
    }
}
