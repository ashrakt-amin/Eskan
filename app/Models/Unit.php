<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Unit extends Model
{
    use HasFactory;

    const IMAGE_PATH = 'Units';

    protected $appends = ['path' , 'levelimgpath'];

    protected $fillable = ['number', 'contract', 'rooms', 'duration', 'level_id', 'space', 'meter_price',
                           'advance_rate', 'advance', 'installment', 'type_id', 'project_id', 'unit_image_id',
                           'block_id', 'appear', 'img' , 'revenue' ,'levelimg','step','receiving'];
    

    public function type()
    {
        return $this->belongsTo(UnitsType::class, 'type_id');
    }


    public function unitImage()
    {
        return $this->belongsTo(UnitsImage::class, 'unit_image_id');
    }



    public function level()
    {
        return $this->belongsTo(Level::class, 'level_id');
    }

    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id');
    }

    public function block()
    {
        return $this->belongsTo(Block::class, 'block_id');
    }

    public function getPathAttribute()
    {
        if (env('APP_URL') == "http://localhost") {
            return asset('storage/images/Units') . "/" . $this->img;
        } else {
            return asset('storage/app/public/images/Units') . "/" . $this->img;
        }
    }

    public function getLevelimgpathAttribute()
    {
        if (env('APP_URL') == "http://localhost") {
            return asset('storage/images/Units') . "/" . $this->levelimg;
        } else {
            return asset('storage/app/public/images/Units') . "/" . $this->levelimg;
        }
    }
    
}
