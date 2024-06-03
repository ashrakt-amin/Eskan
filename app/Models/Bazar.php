<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bazar extends Model
{
    use HasFactory;
    const IMAGE_PATH = 'Bazar';
    protected $appends = ['path'];
    protected $fillable = ['number','space','meter_price','advance','installment','img','revenue','contract', 'section', 'appear'];

    
    public function getPathAttribute()
    {
        if (env('APP_URL') == "http://localhost") {
            return asset('storage/images/Bazar') . "/" . $this->img;
        } else {
            return asset('storage/app/public/images/Bazar') . "/" . $this->img;
        }
    }
}
