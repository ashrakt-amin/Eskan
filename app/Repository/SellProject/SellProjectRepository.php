<?php

namespace App\Repository\SellProject;

use App\Models\Sellproject;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Repository\SellProject\ProjectInterface;
use App\Http\Traits\ResponseTrait as TraitResponseTrait;
use App\Http\Traits\ImageProccessingTrait as TraitImageProccessingTrait;


class SellProjectRepository implements SellProjectInterface
{
    use TraitResponseTrait, TraitImageProccessingTrait;
    public $model;

    protected $resourceCollection;

    public function __construct(Sellproject $model)
    {
        $this->model = $model;
    }

    public function all(): Collection
    {
        return $this->model->all();
    }


    public function store(array $attributes)
    {
        try {
            $attributes['img'] = $this->aspectForResize($attributes['img'], Sellproject::IMAGE_PATH, 500, 600);
            $project = $this->model->create($attributes);
            return $project;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }



    public function find($id): ?Sellproject
    {
        return $this->model->findOrFail($id);
    }



    public function edit($attributes , $id): ?Sellproject
    {
        try {
            $project = $this->model->findOrFail($id);
            $user = Auth::User()->id ;
           
            return   $project->users->get ; 
            // if(){

            // }

            if ($attributes['img']) {
                $this->deleteImage(Sellproject::IMAGE_PATH, $project->img);
                $img = $this->aspectForResize($attributes['img'], Sellproject::IMAGE_PATH, 500, 600);
                $project->update(['img' => $img]);
            } else {
                $project->update($attributes->all());
            }
            return $project;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }



    public function delete($id)
    {
        $data =  $this->model::findOrFail($id);
        $this->deleteImage(Sellproject::IMAGE_PATH, $data->img);
        return $data->delete();
    }
}
