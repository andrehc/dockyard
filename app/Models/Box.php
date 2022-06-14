<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Box extends Model
{
    use HasFactory, Uuid;
    
    public $keyType = 'string';
    public $incrementing = false;
    public $fillable = [
        'height',
        'width',
        'length',
        'container_id',
        'weight'
    ];

    public function container()
    {
        return $this->belongsTo(Container::class);
    }

    public function getVolumeAttribute()
    {
        return round(($this->width * $this->length * $this->height) / 1000000, 2);
    }    
}
