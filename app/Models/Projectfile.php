<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Projectfile extends Model
{
    use HasFactory;
    const File_PATH = 'ProjectWallet/File';
    protected $appends = ['path'];
    protected $fillable = ['file','real_estate_project_id','name'];


    public function ProjectWallet()
    {
        return $this->belongsTo(RealEstateProject::class, 'real_estate_project_id');
    }

    public function getPathAttribute()
    {
        if (env('APP_URL') == "http://localhost") {
            return asset('storage/images/ProjectWallet/File') . "/" . $this->file;
        } else {
            return asset('storage/app/public/images/ProjectWallet/File') . "/" . $this->file;
        }
    }

}
