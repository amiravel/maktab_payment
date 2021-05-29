<?php

namespace App\Models;

use Cerbero\QueryFilters\FiltersRecords;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Refund extends Model
{
    use HasFactory;
    use SoftDeletes;
    use FiltersRecords;

    protected $fillable = ['payment_id', 'uuid', 'name', 'mobile', 'email', 'amount', 'refID', 'card_number', 'iban', 'description', 'seen'];

    protected $casts = [
        'seen' => 'boolean'
    ];

    protected static function booted()
    {
        self::creating(function ($user) {
            if (empty($user->uuid)) {
                $user->uuid = (string)Str::uuid();
            }
        });
    }

    public function getRouteKeyName()
    {
        return 'uuid';
    }

    protected function serializeDate($date)
    {
        return jdate($date);
    }

    public function setIbanAttribute($value)
    {
        $this->attributes['iban'] = Str::replaceFirst("-", "", Str::replaceFirst("IR", "", $value));
    }

    public function payment()
    {
        return $this->belongsTo(Payment::class);
    }

    public function markAsRead($read = true)
    {
        if (!$this->seen)
            $this->update([
                'seen' => $read
            ]);
    }
}
