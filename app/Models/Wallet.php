<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Wallet extends Model
{
    use HasFactory , SoftDeletes;
    protected $fillable = ['name','job','address','phone','whats','join_reason','average_money','installement','feedback'];
}
