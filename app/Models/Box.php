<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class Box extends Model
{
    use HasFactory;
    protected $keyType = 'string';

    public function container()
    {
        return $this->belongsTo(Container::class);
    }

    public function getVolumeAttribute()
    {
        return ($this->width * $this->length * $this->height) / 1000000;
    }

    protected static function booted()
    {
        static::creating(fn (Box $box) => $box->id = (string) Uuid::uuid4());
    }
}
