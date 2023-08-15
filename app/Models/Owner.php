<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Owner extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['name', 'phone', 'job', 'address', 'unit_type', 'price', 'premium' ,'feedback'];
}
