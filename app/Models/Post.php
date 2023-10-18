<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $appends = ['path'];

    protected $fillable = ['user_id','title','text','img'];


    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }


    public function getPathAttribute()
    {
        if (env('APP_URL') == "http://localhost") {
            return asset('storage/Social/post/'.$this->img);
        } else {
            return asset('storage/app/public/Social/post/'. $this->img);
        }
    }
}