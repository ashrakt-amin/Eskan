<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;
    const IMAGE_PATH = 'project';
    protected $appends = ['path'];
    protected $fillable = ['name','img'];

    public function getPathAttribute()
    {
        if (env('APP_URL') == "http://localhost") {
            return asset('storage/images/Eskan/project') . "/" . $this->img;
        } else {
            return asset('storage/app/public/images/Eskan/project') . "/" . $this->img;
        }
    }
}
