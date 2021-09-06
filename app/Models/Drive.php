<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Drive extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'value'
    ];

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
}
