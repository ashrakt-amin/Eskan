<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    const IMAGE_PATH = 'users';
    protected $appends = ['path'];
    protected $fillable = ['name', 'password', 'phone', 'role', 'img' , 'parent_id'];


    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function Sellprojects()
    {
        return $this->belongsToMany(Sellproject::class);
    }

    public function projectUsers()
    {
        return $this->hasManyThrough(Sellproject::class , User::class);
    }
    public function getPathAttribute()
    {
        if (env('APP_URL') == "http://localhost") {
            return asset('storage/images/users') . "/" . $this->img;
        } else {
            return asset('storage/app/public/images/users') . "/" . $this->img;
        }
    }

    public function children()
    {
        return $this->hasMany(User::class, 'parent_id');
    }

    public function parent()
    {
        return $this->belongsTo(User::class, 'parent_id');
    }

    public function clients()
    {
        return $this->hasMany(FormSell::class);
    }

    
}
