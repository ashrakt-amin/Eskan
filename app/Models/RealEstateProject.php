<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RealEstateProject extends Model
{
    use HasFactory;
    const IMAGE_PATH = 'ProjectWallet/img';
    protected $appends = ['path'];
    protected $fillable = ['id','name','img','address','resale','link', 'description', 'detalis','features'];
   
    public function files()
    {
        return $this->hasMany(Projectfile::class );
    }

    public function getPathAttribute()
    {
        if (env('APP_URL') == "http://localhost") {
            return asset('storage/images/ProjectWallet/img') . "/" . $this->img;
        } else {
            return asset('storage/app/public/images/ProjectWallet/img') . "/" . $this->img;
        }
    }
}
