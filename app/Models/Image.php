<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;
    const IMAGE_PATH = 'Eskan';
    protected $appends = ['path'];
    protected $fillable = ['name' , 'img'];

   
    
    public function getPathAttribute()
    {
        if (env('APP_URL') == "http://localhost") {
            return asset('storage/images/Eskan') . "/" . $this->img;
        } else {
            return asset('storage/app/public/images/Eskan') . "/" . $this->img;
        }
    }
}
