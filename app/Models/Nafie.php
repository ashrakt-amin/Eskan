<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nafie extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'phone', 'type'];
}
