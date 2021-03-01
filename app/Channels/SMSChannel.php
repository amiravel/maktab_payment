<?php


namespace App\Channels;


use App\Models\Payment;
use App\Models\PaymentLog;
use App\Notifications\InvoicePaid;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class SMSChannel
{

    public function send($notifiable, Notification $notification)
    {
        /**
         * @var $paymentLog PaymentLog
         */
        $paymentLog = $notification->toSMS($notifiable);

        /** @var Payment $payment */
        $payment = $paymentLog->payment;

        $tags = $payment->tags->implode('name', ', ');

        $message = <<<EOD
$payment->name عزیز
پرداخت شما به مبلغ $payment->amount تومان جهت $tags با موفقیت انجام شد.
اطلاع‌رسانی‌های بعدی متعاقبا صورت خواهد گرفت.

لغو دریافت پیامک با ارسال off
#مکتب_شریف
EOD;

        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            'Accept-Encoding' => 'gzip, deflate, br'
        ])->get('http://textsms.ir/send_via_get/send_sms.php', [
            'username' => env('TEXT_SMS_USERNAME'),
            'password' => env('TEXT_SMS_PASSWORD'),
            'note' => $message,
            'receiver_number' => $payment->mobile,
            'sender_number' => env('TEXT_SMS_NUMBER'),
        ]);

        info($payment->id . $response->body());

        if (Str::contains($response->body(), 'error')) {
            $paymentLog->notify(
                (new InvoicePaid($paymentLog))->delay(now()->addSeconds(10))
            );
        }
    }
}
