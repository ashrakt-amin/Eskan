<?php

namespace App\Http\Controllers\Api;

use App\Models\Project;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProjectRequest;
use App\Repository\Project\ProjectInterface;
use App\Http\Resources\Project\ProjectResource;
use App\Http\Traits\ResponseTrait as TraitResponseTrait;


class ProjectController extends Controller
{
    use TraitResponseTrait;
    protected $Repository;

    public function __construct(ProjectInterface $Repository)
    {
        $this->Repository = $Repository;
    }

    public function index(Request $request)
    {
        $data = $this->Repository->all($request->all());
        return $this->sendResponse(ProjectResource::collection($data), " ", 200);
    }

    public function store(ProjectRequest $request)
    {
       $data = $this->Repository->store($request->validated());
        return $this->sendResponse($data , "تم تسجيل مشروعا جديدا", 200);
    }



    public function show($id)
    {
        $data = $this->Repository->find($id);
        return $this->sendResponse(new ProjectResource($data), " ", 200);
    }


    public function update(Request $request, $id)
    {
        return $this->sendResponse($this->Repository->edit($id, $request), " تم تعديل المشروع", 200);
    }

    
    public function updateImage(Request $request, $id)
    {
        return $this->sendResponse($this->Repository->editImage($id, $request), " تم تعديل ", 200);
    }


    public function deleteImage($id)
    {
        return $this->sendResponse($this->Repository->delete_Image($id), " تم حذف ", 200);
    }


    public function destroy($id)
    {
        return $this->sendResponse($this->Repository->delete($id), " تم حذف المشروع ", 200);
    }
}
