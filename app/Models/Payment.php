<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'name', 'mobile', 'email', 'description', 'amount', 'callback'
    ];

    protected $touches = [
        'logs'
    ];

    protected $casts = [
        'amount' => 'integer'
    ];

    public function setDescriptionAttribute($value)
    {
        $this->attributes['description'] = $value;
        $this->attributes['description'] .= PHP_EOL;
        $this->attributes['description'] .= sprintf('«نام پرداخت کننده: %s»', $this->attributes['name']);
    }

    public function logs()
    {
        return $this->hasMany(PaymentLog::class)
            ->latest();
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    protected function serializeDate($date)
    {
        return jdate($date);
    }

    public function getDriveAttribute()
    {
        return $this->tags()->whereHas('drive')->first()->drive ?? [
                'name' => 'زرین پال',
                'value' => 'zarinpal'
            ];
    }
}
