<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ContactUs extends Model
{
    use HasFactory , SoftDeletes ;
    protected $fillable = ['name' , 'phone' , 'unit_type' , 'space' , 'breif' ,'feedback'] ;

  
}
