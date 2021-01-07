<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Drive extends Model
{
    use HasFactory;

    protected $fillable = [
        'tag_id', 'name', 'value'
    ];

    public function tag()
    {
        return $this->belongsTo(Tag::class);
    }
}
