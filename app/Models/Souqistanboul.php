<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Souqistanboul extends Model
{
    use HasFactory;

    protected $fillable = ['name','phone','shopnumber', 'feedback'];
}
