<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SeekMoney extends Model
{
    use HasFactory , SoftDeletes;

    protected $fillable = ['name','phone','address','job','face_book_active','work_background','has_wide_netWork' ,'feedback'];

    
}
