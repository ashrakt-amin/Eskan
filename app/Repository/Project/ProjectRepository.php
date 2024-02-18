<?php

namespace App\Repository\Project;

use App\Models\Project;
use App\Models\Projectimages;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Repository\Project\ProjectInterface;
use App\Http\Traits\ResponseTrait as TraitResponseTrait;
use App\Http\Traits\ImageProccessingTrait as TraitImageProccessingTrait;


class ProjectRepository implements ProjectInterface
{
    use TraitResponseTrait, TraitImageProccessingTrait;
    public $model;

    protected $resourceCollection;

    public function __construct(Project $model)
    {
        $this->model = $model;
    }

    public function all(): Collection
    {
        return $this->model->all();
    }


    public function store(array $attributes)
    {
        $project = $this->model->create($attributes);
        $project->projectimages()->createMany($this->setImages($attributes['img'], Projectimages::IMAGE_PATH, 'img'));

        // $project = Projectimages::create($attributes);
        return $project;
    }



    public function find($id): ?Project
    {
        return $this->model->findOrFail($id);
    }



    public function edit($id,  $attributes): ?Project
    {
        $project = $this->model->findOrFail($id);
        $data = $attributes->all();
        if($attributes['img']){
            $project->projectimages()->createMany($this->setImages($attributes['img'], Projectimages::IMAGE_PATH, 'img'));
        }
        $project->update($data);
        return $project;
        
    }

    public function editImage($id,  $attributes)
    {

        $project = Projectimages::findOrFail($id);
        $this->deleteImage(Projectimages::IMAGE_PATH, $project->img);
        $img = $this->aspectForResize($attributes['img'], Projectimages::IMAGE_PATH);
        $project->update(['img' => $img]);
        return $project;
    }


    public function delete($id)
    {
        $user = Auth::user();
        $data =  $this->model::findOrFail($id);
        $this->deleteImage(Projectimages::IMAGE_PATH, $data->img);

        $user = ['name' => $user->name, 'phone' => $user->phone];
        $project = ['project name' => $data->name];
        $log_data = ['The user who deleted the project' => $user, 'The project ' => $project];
        Log::channel('project')->info('project', $log_data);

        return $data->delete();
    }

    public function delete_Image($id)
    {
        $data = Projectimages::findOrFail($id);
        $this->deleteImage(Projectimages::IMAGE_PATH, $data->img);
        return $data->delete();
    }
}
