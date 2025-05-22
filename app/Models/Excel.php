<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Excel extends Model
{
    use HasFactory;
    const IMAGE_PATH = 'files';
    protected $appends = ['path'];
    protected $fillable = ['name', 'file'];



    public function getPathAttribute()
    {
        if (env('APP_URL') == "http://localhost") {
            return asset('storage/images/files') . "/" . $this->file;
        } else {
            return asset('storage/app/public/images/files') . "/" . $this->file;
        }
    }
}
