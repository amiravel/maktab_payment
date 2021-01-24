<?php


namespace App\Actions\Payment;


use App\Models\Payment;
use Lorisleiva\Actions\Concerns\AsAction;

class PaymentMarkAsRead
{
    use AsAction;

    public function handle(Payment $payment)
    {
        $payment->markAsRead();
    }
}
