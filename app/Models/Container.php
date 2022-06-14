<?php

namespace App\Models;

use DomainException;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use LogicException;

class Container extends Model
{
    use HasFactory, SoftDeletes;

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

    public function boxes()
    {
        return $this->hasMany(Box::class);
    }

    public function getVolumeAttribute()
    {
        return round(($this->width * $this->length * $this->height) / 1000000, 2);
    }

    public function getNetWeightAttribute()
    {
        $net_weight = 0;
        foreach ($this->boxes as $box) {
            $net_weight+= $box->weight;
        }
        return round($net_weight/1000, 2);
    }

    public function getGrossWeightAttribute()
    {        
        $gross_weight = $this->net_weight + ($this->tare_weight/1000);

        return round($gross_weight, 2); 
    }

    public function getNetVolumeAttribute()
    {
        $net_volume = 0;
        foreach ($this->boxes as $box) {
            $net_volume += $box->volume;
        }
        return round($net_volume, 2);
    }

    public function getFreeVolumeAttribute()
    {
        return round($this->volume - $this->net_volume, 2);
    }

    public function delete()
	{
        if($this->boxes()->exists()){
            throw new DomainException('This container has boxes and can not be deleted');
        }
		
        return parent::delete();
	}	
}
