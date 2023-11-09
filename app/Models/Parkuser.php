<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Parkuser extends Model
{
    use HasFactory ,SoftDeletes;
    protected $fillable = ['project_id','name','phone', 'job','national_ID','space','products_type','feedback','type'];
    public function project(){
        return $this->belongsTo(Project::class ,'project_id');
    }
}
