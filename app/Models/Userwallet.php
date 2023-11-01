<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Userwallet extends Model
{
    use HasFactory , SoftDeletes ;
    protected $fillable = ['name','phone','shares_num','walletunit_id','feedback'];

    public function unit(){
        return $this->belongsTo(Walletunit::class,'walletunit_id');
    }
}
