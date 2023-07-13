<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    use HasFactory;
    const IMAGE_PATH = 'Units';
    protected $appends = ['path'];

    protected $fillable = ['number', 'img','contract', 'rooms', 'duration', 'level_id', 'space', 'meter_price',
                           'advance_rate' , 'advance', 'installment', 'type_id', 'project_id'];

    public function type()
    {
        return $this->belongsTo(UnitsType::class, 'type_id');
    }

    public function level()
    {
        return $this->belongsTo(Level::class, 'level_id');
    }

    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id');
    }

    public function getPathAttribute()
    {
        if (env('APP_URL') == "http://localhost") {
            return asset('storage/images/Units') . "/" . $this->img;
        } else {
            return asset('storage/app/public/images/Units') . "/" . $this->img;
        }
    }
}
