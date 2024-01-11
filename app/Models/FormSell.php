<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormSell extends Model
{
    use HasFactory;
    protected $fillable = ['name','phone','date','user_id'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
