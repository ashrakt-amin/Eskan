<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UnitsImage extends Model
{
    use HasFactory;
    const Unit_PATH = 'Units';
    const Block_PATH = 'Units/block';

    protected $appends = ['unitpath','blockpath'];
    protected $fillable = ['unit_img', 'block_img'] ;

    public function unit()
    {
        return $this->hasMany(Unit::class);
    }

    public function getUnitPathAttribute()
    {
        if (env('APP_URL') == "http://localhost") {
            return asset('storage/images/Units') . "/" . $this->unit_img;
        } else {
            return asset('storage/app/public/images/Units') . "/" . $this->unit_img;
        }
    }

    
    public function getBlockPathAttribute()
    {
        if (env('APP_URL') == "http://localhost") {
            return asset('storage/images/Units/block') . "/" . $this->block_img;
        } else {
            return asset('storage/app/public/images/Units/block') . "/" . $this->block_img;
        }
    }
}
