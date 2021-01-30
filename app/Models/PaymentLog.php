<?php

namespace App\Models;

use App\Enums\PaymentLogCase;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class PaymentLog extends Model
{
    use HasFactory;
    use Notifiable;

    protected $fillable = [
        'payment_id', 'status', 'type', 'authority', 'message', 'refID'
    ];

    public function payment()
    {
        return $this->belongsTo(Payment::class);
    }

    protected function serializeDate($date)
    {
        return jdate($date);
    }
}
