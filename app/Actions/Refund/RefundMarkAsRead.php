<?php


namespace App\Actions\Refund;


use App\Models\Refund;
use Lorisleiva\Actions\Concerns\AsAction;

class RefundMarkAsRead
{
    use AsAction;

    public function handle(Refund $refund)
    {
        $refund->markAsRead();
    }
}
