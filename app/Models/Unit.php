<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    use HasFactory;
    protected $fillable = ['number','space','meter_price','advance', 'installment','type_id','project_id'];

    public function type(){
        return $this->belongsTo(UnitsType::class ,'type_id');
    }

    public function project(){
        return $this->belongsTo(Project::class ,'project_id');
    }
}
