<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Walletunit extends Model
{
    use HasFactory;
    const IMAGE_PATH = 'walletUnits';
    protected $appends = ['path'];
    protected $fillable = ['project_id','img','num','shares_num',
                          'contracted_shares','share_price','share_meter_num','return'];
    public function unit()
    {
        return $this->hasOne(Unit::class);
    }

    public function getPathAttribute()
    {
        if (env('APP_URL') == "http://localhost") {
            return asset('storage/images/walletUnits') . "/" . $this->img;
        } else {
            return asset('storage/app/public/images/walletUnits') . "/" . $this->img;
        }
    }

}
