<?php

namespace App\Http\Controllers\Api;

use App\Models\Job;
use Illuminate\Http\Request;
use App\Http\Requests\JobRequest;
use App\Http\Resources\JobResource;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Traits\ResponseTrait as TraitResponseTrait;
use App\Http\Traits\ImageProccessingTrait as TraitImageProccessingTrait;

class JobController extends Controller
{
    use TraitImageProccessingTrait, TraitResponseTrait;

    public function index()
    {
        $data = Job::all();
        return $this->sendResponse(JobResource::collection($data), "all jobs", 200);
    }

    public function store(JobRequest $request)
    {
        $request->validated();
        $cv =  $request['cv'];
        $cv_name = date('YmdHi') . $cv->getClientOriginalName();
        $cv->move(storage_path('app/public/images/' . Job::CV), $cv_name);

        if ($request['person_img'] != NULL || isset($request['person_img'])) {
            $person_img =  $request['person_img'];
            $person_img_name = date('YmdHi') . $person_img->getClientOriginalName();
            $person_img->move(storage_path('app/public/images/' . Job::person), $person_img_name);
        } else {
            $person_img_name = NULL;
        }

        if ($request['last_project '] != NULL || isset($request['last_project'])) {
            $last_project =  $request['last_project'];
            $last_project_name = date('YmdHi') . $last_project->getClientOriginalName();
            $last_project->move(storage_path('app/public/images/' . Job::Project), $last_project_name);
        } else {
            $last_project_name  = NULL;
        }

        Job::create([
            'job_title'          => $request->job_title,
            'name'               => $request->name,
            'phone'              => $request->phone,
            'cv'                 => $cv_name,
            'person_img'         => $person_img_name,
            'last_project'       => $last_project_name,
            'last_project_info'  => $request->last_project_info,
            'feedback'           => $request->feedback,
        ]);

        return $this->sendResponse("success", "تم الحفظ", 200);
    }

    public function show($id)
    {
        $data = Job::findOrFail($id);
        return $this->sendResponse(new JobResource($data), "success", 200);
    }

    public function update($id, Request $request)
    {
        $data = Job::findOrFail($id);
        if ($request['feedback'] != null || $request['feedback'] == '') {
            $data->update([
                'feedback'  => $request['feedback']
            ]);
        }
        return $this->sendResponse(new JobResource($data), "success", 200);
    }

    // public function updateImage(Request $request)
    // {
    //     $image = Image::findOrFail($request->id);
    //     $request->validate([
    //         'id'         => 'required'
    //     ]);
    //     if ($request->img) {
    //         $this->deleteImage(Image::IMAGE_PATH, $image->img);
    //     }
    //     $img = $this->aspectForResize($request['img'], Image::IMAGE_PATH, 500, 600);
    //     $image->update([
    //         'img'  => $img
    //     ]);
    //     return $this->sendResponse($image, "update", 200);
    // }


    public function destroy($id)
    {
        $data = Job::findOrFail($id);
        $this->deleteImage(Job::CV, $data->cv);
        $this->deleteImage(Job::person, $data->person_img);
        $this->deleteImage(Job::Project, $data->last_project);
        $data->delete();
        return $this->sendResponse('', "delete", 200);
    }
}
