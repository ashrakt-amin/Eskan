<?php

namespace App\Repository\Project;

use App\Models\Project;
use Illuminate\Support\Collection;
use App\Repository\Project\ProjectInterface;
use App\Http\Traits\ResponseTrait as TraitResponseTrait;
use App\Http\Traits\ImageProccessingTrait as TraitImageProccessingTrait;


class ProjectRepository implements ProjectInterface
{
    use TraitResponseTrait ,TraitImageProccessingTrait;
    public $model;

    protected $resourceCollection;

    public function __construct(Project $model)
    {
        $this->model = $model  ;
      }

    public function all(): Collection
    {
       return $this->model->all();

    }


    public function store(array $attributes)
    {
        $attributes['img']= $this->aspectForResize($attributes['img'], Project::IMAGE_PATH, 500, 600);

        $project = $this->model->create($attributes);
        return $project ;
    }



    public function find($id): ?Project
    {
        return $this->model->findOrFail($id);
    }



    public function edit($id,  $attributes): ?Project
    {

        $project =$this->model->findOrFail($id);
        $data = $attributes->all();
    if ($attributes['img']) {
        $this->deleteImage( Project::IMAGE_PATH, $project->img);
        $img = $this->aspectForResize($attributes['img'], Project::IMAGE_PATH, 500, 600);
        $project->update(['img' => $img]);
    }else{
        $project->update($data);

    }
       
        return $project;
    }


    public function delete($id)
    {
      $data =  $this->model::findOrFail($id);
        $this->deleteImage( Project::IMAGE_PATH, $data->img);
       return $data->delete();
       
    }
}
