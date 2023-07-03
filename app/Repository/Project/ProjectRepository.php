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



    public function edit($id, array $attributes): ?Project
    {

        $project = Project::findOrFail($id);
        $project->update($attributes);
        return $project;
    }


    public function delete($id)
    {
       $this->model::findOrFail($id)->delete;
       
        return $this->sendResponse(" ", "تم حذف المشروع بشكل نهائى", 200);
    }
}
