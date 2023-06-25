<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SeekMoney extends Model
{
    use HasFactory;

    protected $fillable = ['name','phone','address','job','face_book_active','work_background','has_wide_netWork'];

    
}
