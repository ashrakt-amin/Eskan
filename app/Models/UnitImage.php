<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UnitImage extends Model
{
    use HasFactory; 
    const IMAGE_PATH = 'Units';
    protected $appends = ['path'];
    protected $fillable =['img','unit_id'];

    public function unit()
    {
        return $this->hasOne(Unit::class);
    }

    public function getPathAttribute()
    {
        if (env('APP_URL') == "http://localhost") {
            return asset('storage/images/Units') . "/" . $this->img;
        } else {
            return asset('storage/app/public/images/Units') . "/" . $this->img;
        }
    }
}
