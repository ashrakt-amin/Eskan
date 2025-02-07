<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Souqistanboulform extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'phone', 'contact_time', 'shop_number','region', 'contract'];

}
