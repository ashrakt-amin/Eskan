<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Block extends Model
{
    use HasFactory;
    const IMAGE_PATH = 'block';
    protected $appends = ['path'];
    protected $fillable = ['img','name','project_id'];
   
    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function getPathAttribute()
    {
        if (env('APP_URL') == "http://localhost") {
            return asset('storage/images/project'). "/"  . $this->project->name . "/" . $this->img;
        } else {
            return asset('storage/app/public/images/project') . "/" . $this->project->name . "/" . $this->img;
        }
    }
}
