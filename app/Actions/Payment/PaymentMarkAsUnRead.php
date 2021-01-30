<?php


namespace App\Actions\Payment;


use App\Models\Payment;
use Lorisleiva\Actions\Concerns\AsAction;

class PaymentMarkAsUnRead
{
    use AsAction;

    public function handle(Payment $payment)
    {
        $payment->markAsUnRead();
    }
}
