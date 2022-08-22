<?php

namespace App\Notifications;

use App\Channels\SMSChannel;
use App\Models\PaymentLog;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class InvoicePaid extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * @var PaymentLog
     */
    private $paymentLog;

    /**
     * Create a new notification instance.
     *
     * @param PaymentLog $paymentLog
     */
    public function __construct(PaymentLog $paymentLog)
    {
        $this->paymentLog = $paymentLog;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return [SMSChannel::class];
    }

    // toFoo
    public function toSMS($notifiable)
    {
        return $this->paymentLog;
    }
}
