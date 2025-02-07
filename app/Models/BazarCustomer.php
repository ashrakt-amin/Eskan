<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BazarCustomer extends Model
{
    use HasFactory;

    protected $fillable = ['name','phone', 'contact_time','bazar_number','feedback','section','contract', 'national_id'];
    
}
