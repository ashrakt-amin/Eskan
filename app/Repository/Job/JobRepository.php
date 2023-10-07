<?php

namespace App\Repository\Job;

use Exception;
use App\Models\Job;
use Illuminate\Support\Collection;
use App\Http\Traits\ResponseTrait as TraitResponseTrait;
use App\Http\Traits\ImageProccessingTrait as TraitImageProccessingTrait;

class JobRepository implements JobInterface
{
    use TraitResponseTrait, TraitImageProccessingTrait;
    public $model;

    protected $resourceCollection;

    public function __construct(Job $model)
    {
        $this->model = $model;
    }

    public function all(): Collection
    {
        return $this->model->all();
    }


    public function store(array $request)
    {
        try {
            $cv =  $request['cv'];
            $cv_name = date('YmdHi') . $cv->getClientOriginalName();
            $cv->move(storage_path('app/public/images/' . Job::CV), $cv_name);
    
            if (isset($request['person_img'])) {
                $person_img =  $request['person_img'];
                $person_img_name = date('YmdHi') . $person_img->getClientOriginalName();
                $person_img->move(storage_path('app/public/images/' . Job::person), $person_img_name);
            } else {
                $person_img_name = NULL;
            }
            if (isset($request['last_project'])) {
                $last_project =  $request['last_project'];
                $last_project_name = date('YmdHi') . $last_project->getClientOriginalName();
                $last_project->move(storage_path('app/public/images/' .Job::Project), $last_project_name);
            } else {
                $last_project_name = NULL;
            }
    
            
    
            Job::create([
                'job_title'          => $request['job_title'],
                'name'               => $request['name'],
                'phone'              => $request['phone'],
                'cv'                 => $cv_name,
                'person_img'         => $person_img_name,
                'last_project'       => $last_project_name ,
                'last_project_info'  => $request['last_project_info'],
                'feedback'           => $request['feedback'],
                'facebook'           => $request['facebook'],
            ]);
    
            return true;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }



    public function find($id): ?Job
    {
        return $this->model->findOrFail($id);
    }



    public function edit($id,$request)
    {
        try {
            $data = Job::findOrFail($id);
            if ($request['feedback'] != null || $request['feedback'] == '') {
                $data->update([
                    'feedback'  => $request['feedback']
                ]);
            }
            return true;
        } catch (\Exception $e) {

            return $e->getMessage();
        }
    }

    public function delete($id)
    {
        $data = Job::findOrFail($id);
        $this->deleteImage(Job::CV, $data->cv);
        $this->deleteImage(Job::person, $data->person_img);
        $this->deleteImage(Job::Project, $data->last_project);
        $data->delete();
        return true;
    }

   

    public function theLatest(array $attributes)
    {
        return function ($q) use ($attributes) {
            !array_key_exists('latest', $attributes) ?: $q
                ->latest();
        };
    }



    public function forAllConditions(array $attributes)
    {
        return $this->model
            ->where($this->theLatest($attributes))
;
            }


    public function forAllConditionsPaginate(array $attributes, $resourceCollection)
    {
        $this->resourceCollection = $resourceCollection;

        return
            $this->paginateResponse(
                $this->resourceCollection::collection($this->forAllConditions($attributes)
                    ->paginate(array_key_exists('count', $attributes) ? $attributes['count'] : "")),
                $this->forAllConditions($attributes)->paginate(array_key_exists('count', $attributes) ? $attributes['count'] : ""),
                "paginate data; Youssof",
                200
            );
    }


    public function forAllConditionsLatest(array $attributes, $resourceCollection)
    {
        $this->resourceCollection = $resourceCollection;

        return
            $this->paginateResponse(
                $this->resourceCollection::collection($this->forAllConditions($attributes)
                    ->latest()->limit(array_key_exists('limit', $attributes) ? $attributes['limit'] : "")
                    ->paginate(array_key_exists('count', $attributes) ? $attributes['count'] : "")),
                $this->forAllConditions($attributes)->latest()->limit(array_key_exists('limit', $attributes) ? $attributes['limit'] : "")
                    ->paginate(array_key_exists('count', $attributes) ? $attributes['count'] : ""),
                "Latest data; Youssof",
                200
            );
    }



    public function forAllConditionsRandom(array $attributes, $resourceCollection)
    {
        $this->resourceCollection = $resourceCollection;

        return
            $this->sendResponse(
                $this->resourceCollection::collection($this->forAllConditions($attributes)->inRandomOrder()->limit(array_key_exists('count', $attributes) ? $attributes['count'] : "")->get()),
                "Random data; Youssof",
                200
            );
    }



    public function forAllConditionsReturn(array $attributes, $resourceCollection)
    {
        $this->resourceCollection = $resourceCollection;

        return array_key_exists('paginate', $attributes) || array_key_exists('card', $attributes) ||
            array_key_exists('table', $attributes) || array_key_exists('status', $attributes)
            ? $this->forAllConditionsPaginate($attributes, $resourceCollection)
            : (array_key_exists('latest', $attributes) ? $this->forAllConditionsLatest($attributes, $resourceCollection)
                : $this->forAllConditionsRandom($attributes, $resourceCollection));
    }
}
