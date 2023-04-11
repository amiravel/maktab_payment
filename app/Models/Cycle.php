<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Cycle extends Model
{
    use HasFactory;

    protected $fillable = [
        'first',
        'center',
        'second_center',
        'end',
        'percentage',
        'drives',
        'ended_at'
    ];

    protected $casts = [
        'ended_at' => 'datetime',
        'drives' => 'array'
    ];

    protected $with = [
        'payments'
    ];

    public function payments(): BelongsToMany
    {
        return $this->belongsToMany(Payment::class)
            ->successful();
    }

    public function getDriveAttribute()
    {
        // temporary move to pasargad gateway
        // return $this->drives[0];

        $total_payments = $this->payments()->sum('amount');

        if ($total_payments <= $this->center)
            return $this->drives[0];

        return $this->drives[1];
    }

    public function getIsFullAttribute()
    {
        return $this->payments()->sum('amount') >= $this->max;
    }

    public function getIsEqualCenterAttribute(){
        return $this->center == $this->second_center;
    }

    public function getMaxAttribute(){
        return round(($this->center * 100) / $this->percentage);
    }
}
