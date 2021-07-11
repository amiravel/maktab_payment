<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;

    protected $fillable = [
        'parent', 'name', 'public'
    ];

    protected $casts = [
        'public' => 'boolean'
    ];

    protected $with = [
        'drive', 'children'
    ];

    public function parent()
    {
        return $this->hasOne(Tag::class, 'id', 'parent');
    }

    public function children()
    {
        return $this->hasMany(Tag::class, 'parent', 'id');
    }

    public function payment()
    {
        return $this->belongsToMany(Payment::class);
    }

    public function drive()
    {
        return $this->belongsToMany(Drive::class);
    }

    protected function serializeDate($date)
    {
        return jdate($date);
    }
}
