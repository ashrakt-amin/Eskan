<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Text extends Model
{
    use HasFactory;

    const IMAGE_PATH = 'Blog';
    protected $appends = ['path'];
    protected $fillable = ['name','description','img','title'];



public function getPathAttribute()
{
    if($this->img !== null){
    if (env('APP_URL') == "http://localhost" ) {
       
        return asset('storage/images/Blog') . "/" . $this->img;
    } else {
        return asset('storage/app/public/images/Blog') . "/" . $this->img;
    }

}
}
}
