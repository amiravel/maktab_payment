<?php

namespace App\Models;

use Cerbero\QueryFilters\FiltersRecords;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Propaganistas\LaravelPhone\Casts\RawPhoneNumberCast;

class Payment extends Model
{
    use HasFactory;
    use FiltersRecords;

    protected $fillable = [
        'user_id', 'name', 'mobile', 'email', 'description', 'amount', 'callback', 'information', 'read'
    ];

    protected $touches = [
        'logs'
    ];

    protected $casts = [
        'amount' => 'integer',
        'information' => 'array',
        'mobile' => RawPhoneNumberCast::class . ':IR',
    ];

    public function setDescriptionAttribute($value)
    {
        $this->attributes['description'] = $value;
        $this->attributes['description'] .= PHP_EOL;
        $this->attributes['description'] .= sprintf('«نام پرداخت کننده: %s»', $this->attributes['name']);
    }

    public function getReferenceIDAttribute()
    {
        return $this->logs()->whereNotNull('refID')->first()->refID ?? '';
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    public function logs()
    {
        return $this->hasMany(PaymentLog::class)
            ->latest();
    }

    public function getDriveAttribute()
    {
        $query = $this->tags()->whereHas('drive');

        if ($query->exists())
            return $query->first()->drive()->first();

        return Drive::whereValue('zarinpal')->first();
    }

    public function markAsRead()
    {
        if (!$this->read)
            $this->update([
                'read' => true
            ]);
    }

    public function markAsUnRead()
    {
        if ($this->read)
            $this->update([
                'read' => false
            ]);
    }

    public function status($type): bool
    {
        switch ($type) {
            case "created":
                return $this->IsCreated();

            case "successful":
                return $this->isSuccessful();

            case "error":
                return $this->isError();

            default:
                return false;
        }
    }

    private function IsCreated()
    {
        return $this->logs()
            ->where('status', 100)
            ->where('type', 'before')
            ->whereNull('refID')
            ->exists();
    }

    private function isSuccessful()
    {
        return $this->logs()
            ->where('status', 100)
            ->where('type', 'after')
            ->whereNotNull('refID')
            ->exists();
    }

    private function isError()
    {
        return $this->logs()
            ->where('type', 'after')
            ->whereNotBetween('status', [100, 101])
            ->exists();
    }

    protected function serializeDate($date)
    {
        return jdate($date);
    }

    /**
     * @param $query Builder
     */
    public function scopeCreated($query)
    {
        $query->whereHas('logs', function ($query2) {
            $query2->where('status', 100)
                ->where('type', 'before')
                ->whereNull('refID');
        });
    }

    /**
     * @param $query Builder
     */
    public function scopeSuccessful($query)
    {
        $query->whereHas('logs', function ($query2) {
            $query2->where('status', 100)
                ->where('type', 'after')
                ->whereNotNull('refID');
        });
    }

    /**
     * @param $query Builder
     */
    public function scopeError($query)
    {
        $query->whereHas('logs', function ($query2) {
            $query2->where('type', 'after')
                ->whereNotBetween('status', [100, 101]);
        });
    }

    /**
     * @param $query Builder
     */
    public function scopeDrive($query, $drive)
    {
        $query->whereHas('tags.drive', function ($query2) use ($drive) {
            $query2->where('id', $drive);
        });
    }

    /**
     * @param $query Builder
     * @param $refund Refund
     */
    public function scopeRefund($query, Refund $refund)
    {
        $query->whereHas('logs', function ($query) use ($refund) {
            return $query->where('refID', $refund->refID);
        });
    }
}
