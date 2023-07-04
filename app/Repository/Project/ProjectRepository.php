<?php

namespace App\Repository\Project;

use App\Models\Project;
use Illuminate\Support\Collection;
use App\Repository\Project\ProjectInterface;
use App\Http\Traits\ResponseTrait as TraitResponseTrait;

class ProjectRepository implements ProjectInterface
{
    use TraitResponseTrait;
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
        $project->update($data);
        return $project;
    }


    public function delete($id)
    {
       return $this->model::findOrFail($id)->delete();
       
    }
}
