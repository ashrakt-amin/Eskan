<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;
    protected $fillable = ['name' , 'phone' , 'job' , 'unit_id' , 'project_id'];

    public function unit(){
        return $this->belongsTo(Unit::class,'unit_id');
    }

    public function project(){
        return $this->belongsTo(Project::class,'project_id');
    }


}

