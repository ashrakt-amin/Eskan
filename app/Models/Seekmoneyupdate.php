<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seekmoneyupdate extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'phone', 'type', 'space', 'advance', 'installment', 'responsible', 'feedback'];

}
