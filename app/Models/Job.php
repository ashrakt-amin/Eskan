<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    use HasFactory;
  
    const CV      = 'CV';
    const person  = 'person';
    const Project = 'project';

    protected $appends = ['path', 'person', 'project'];
    
    protected $fillable = [
        'job_title', 'name', 'phone', 'cv', 'person_img',
        'last_project', 'last_project_info', 'feedback', 'facebook'
    ];

    public function getPathAttribute()
    {

        if (env('APP_URL') == "http://localhost") {
            return asset('storage/images/CV') . "/" . $this->cv;
        } else {
            return asset('storage/app/public/images/CV') . "/" . $this->cv;
        }
    }


    public function getPersonAttribute()
    {
        if (env('APP_URL') == "http://localhost") {
            return asset('storage/images/person') . "/" . $this->person_img;
        } else {
            return asset('storage/app/public/images/person') . "/" . $this->person_img;
        }
    }



    public function getProjectAttribute()
    {
        if (env('APP_URL') == "http://localhost") {
            return asset('storage/images/project') . "/" . $this->last_project;
        } else {
            return asset('storage/app/public/images/project') . "/" . $this->last_project;
        }
    }
}
