<?php


namespace App\Channels;


use App\Models\Payment;
use App\Models\PaymentLog;
use App\Notifications\InvoicePaid;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Http;

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

        $response = Http::contentType('Content-Type: text/html; charset=utf-8')
            ->get('http://textsms.ir/webservice/rest/sms_send', [
                'api_key' => env('TEXT_SMS_API_KEY'),
                'note_arr' => $message,
                'receiver_number' => $payment->mobile,
                'sender_number' => env('TEXT_SMS_NUMBER'),
            ]);

        if ($response->failed()) {
            $paymentLog->notify(new InvoicePaid($paymentLog));
        }
    }
}
