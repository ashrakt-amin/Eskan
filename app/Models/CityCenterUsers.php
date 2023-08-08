<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CityCenterUsers extends Model
{
    use HasFactory , SoftDeletes;
    protected $fillable = ['id' , 'name' , 'phone' , 'address' , 'space' , 'activity' ,'job'];
}
