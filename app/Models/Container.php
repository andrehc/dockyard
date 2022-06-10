<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Container extends Model
{
    use HasFactory;

    protected $fillable = [
        'locator',
        'depth',
        'width',
        'length',
        'yard_id'
    ];

    public function yard(){
        return $this->belongsTo(Yard::class);
    }
}
