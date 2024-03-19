<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ownersystem extends Model
{
    use HasFactory;
    protected $fillable = ['id', 'name', 'phone', 'place', 'advance' , 'feedback'];

}
