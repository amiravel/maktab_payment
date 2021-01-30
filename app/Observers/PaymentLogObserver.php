<?php

namespace App\Observers;

use App\Models\PaymentLog;
use App\Notifications\InvoicePaid;
use Illuminate\Support\Facades\Notification;

class PaymentLogObserver
{
    /**
     * Handle the PaymentLog "created" event.
     *
     * @param  \App\Models\PaymentLog  $paymentLog
     * @return void
     */
    public function created(PaymentLog $paymentLog)
    {
        if ($paymentLog->payment->status('successful'))
            $paymentLog->notify(new InvoicePaid($paymentLog));
    }
}
