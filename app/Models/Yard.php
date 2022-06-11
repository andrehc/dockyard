<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Yard extends Model
{
    use HasFactory;

    protected $fillable = [
        'locator',
        'width',
        'length'
    ];

    public function containers()
    {
        return $this->hasMany(Container::class);
    }

    public function getMaximumStackAttribute()
    {
        return config('constants.yard.maximum_stacking');
    }

    public function getAreaAttribute()
    {
        return $this->width * $this-> length;
    }

    public function getStacksAttribute()
    {
        return (int)ceil($this->containers->count() / $this->maximum_stack);
    }
}
