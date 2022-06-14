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
        return round(($this->width * $this-> length) / 10000, 2);
    }

    public function getStacksAttribute()
    {
        return (int)ceil($this->containers->count() / $this->maximum_stack);
    }

    public function getContainerCapacityAttribute()
    {
        $horizontal_container_capacity = (int) floor($this->width / config('constants.container.width'));
        $vertical_container_capacity = (int) floor($this->length / config('constants.container.length'));
        return (int)floor($horizontal_container_capacity * $vertical_container_capacity * $this->maximum_stack);
    }

    public function getContainerFreeCapacityAttribute()
    {
        return $this->container_capacity - $this->containers->count();
    }
}
