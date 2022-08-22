<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

class PaymentLog extends Model
{
    use HasFactory;
    use Notifiable;

    protected $fillable = [
        'payment_id', 'status', 'type', 'authority', 'message', 'refID', 'raw_receipt'
    ];

    protected $casts = [
        'raw_receipt' => 'array'
    ];

    public function payment()
    {
        return $this->belongsTo(Payment::class);
    }

    public function getMaskCardNumberAttribute()
    {
        $card_number = $this->raw_receipt['MaskedCardNumber'] ?? $this->raw_receipt['cardNumber'] ?? false;

        if (!$card_number)
            return false;

        if (Str::contains($card_number, '-'))
            return $card_number;

        return implode("-", str_split($card_number, 4));
    }

    protected function serializeDate($date)
    {
        return jdate($date);
    }
}
