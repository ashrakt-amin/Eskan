<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Walletunit extends Model
{
    use HasFactory;
    const IMAGE_PATH = 'walletUnits';
    protected $appends = ['path'];
    protected $fillable = ['real_estate_project_id','img','num','shares_num',
                          'contracted_shares','share_price','share_meter_num','return'];
    public function Project()
    {
        return $this->belongsto(RealEstateProject::class,'real_estate_project_id');
    }

    public function userswalltunit()
    {
        return $this->hasMany(Userwallet::class);
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
