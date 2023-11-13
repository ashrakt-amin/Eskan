<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Projectimages extends Model
{
    use HasFactory;
    const IMAGE_PATH = 'project';
    protected $appends = ['path'];
    protected $fillable =['project_id','img'];

    public function project()
    {
        return $this->hasOne(Project::class);
    }

    public function getPathAttribute()
    {
        if (env('APP_URL') == "http://localhost") {
            return asset('storage/images/project') . "/" . $this->img;
        } else {
            return asset('storage/app/public/images/project') . "/" . $this->img;
        }
    }
}
