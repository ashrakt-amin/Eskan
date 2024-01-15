<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormSell extends Model
{
    use HasFactory;
    protected $fillable = ['name','phone','date','user_id' ,'sellproject_id','status'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function sellproject()
    {
        return $this->belongsTo(Sellproject::class, 'sellproject_id');
    }
}
