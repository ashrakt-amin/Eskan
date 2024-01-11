<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Sellproject extends Model
{
    use HasFactory;
    const IMAGE_PATH = 'sellProject';

    protected $fillable = ['name','img','description'];
    
    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function getPathAttribute()
    {
        if (env('APP_URL') == "http://localhost") {
            return asset('storage/images/sellProject') . "/" . $this->img;
        } else {
            return asset('storage/app/public/images/sellProject') . "/" . $this->img;
        }
    }

}
