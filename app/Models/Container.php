<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Container extends Model
{
    use HasFactory;

    protected $fillable = [
        'locator',
        'height',
        'width',
        'length',
        'yard_id',
        'tare_weight',
        'max_load_weight'
    ];

    public function yard(){
        return $this->belongsTo(Yard::class);
    }
}
