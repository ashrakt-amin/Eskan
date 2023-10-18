<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;
    protected $fillable = ['comment','user_id','post_id', 'comment_id'];


    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function admin_comment()
    {
        return $this->hasOne(Comment::class, 'comment_id');
    }

    public function post()
    {
        return $this->belongsTo(Post::class, 'post_id');
    }

}