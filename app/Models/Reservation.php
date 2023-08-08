<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Reservation extends Model
{
    use HasFactory , SoftDeletes;
    protected $fillable = ['name' , 'phone' , 'job' , 'unit_id' , 'project_id'];

    public function unit(){
        return $this->belongsTo(Unit::class,'unit_id');
    }

    public function project(){
        return $this->belongsTo(Project::class,'project_id');
    }


}

