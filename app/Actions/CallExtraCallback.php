<?php

namespace App\Actions;

use App\Http\Resources\PaymentResource;
use App\Models\Payment;
use Illuminate\Support\Facades\Http;
use Lorisleiva\Actions\Concerns\AsJob;

class CallExtraCallback
{
    use AsJob;

    public function handle(Payment $payment)
    {
        if (empty($payment->extra_callback))
            return;

        $response = Http::post($payment->extra_callback, [
            'status' => $payment->status('successful'),
            'data' => new PaymentResource($payment)
        ]);

        if ($response->failed())
            $this->dispatch($payment)->delay(now()->addSeconds(10));
    }
}
