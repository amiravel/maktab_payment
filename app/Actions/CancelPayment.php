<?php

namespace App\Actions;

use App\Models\Payment;
use Lorisleiva\Actions\Concerns\AsJob;

class CancelPayment
{
    use AsJob;

    public function handle(Payment $payment)
    {
        if (empty($payment->referenceID)) {
            $payment->markAsRead();

            $payment->logs()->create([
                'status' => 0,
                'type' => 'after',
                'authority' => $payment->logs()->first()->authority,
                'message' => 'مدت زمان پرداخت به اتمام رسید.',
            ]);
        }
    }
}
