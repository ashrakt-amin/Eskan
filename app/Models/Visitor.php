<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Visitor extends Model
{
    use HasFactory;
    
    protected $fillable = ['name', 'phone', 'job', 'address', 'contact_time', 'how', 'why' ,'sales1','sales2'];

}
