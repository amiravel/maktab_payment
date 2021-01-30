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
        if (count(array_diff([134, 131], $paymentLog->payment->tags->pluck('id')->toArray())) < 2)
            if ($paymentLog->payment->status('successful'))
                $paymentLog->notify(new InvoicePaid($paymentLog));
    }
}
