<?php

namespace App\Http\Controllers\Api;

use App\Models\Sellproject;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\SellProjectRequest;
use App\Http\Resources\SellProject\ProjectResource;
use App\Repository\SellProject\SellProjectInterface;
use App\Http\Traits\ResponseTrait as TraitResponseTrait;

class SellProjectController extends Controller
{
    use TraitResponseTrait;
    protected $Repository;

    public function __construct(SellProjectInterface $Repository)
    {
        $this->Repository = $Repository;
    }

    public function index()
    {
        $data = $this->Repository->all();
        return $this->sendResponse(ProjectResource::collection($data), " ", 200);
    }

    public function store(SellProjectRequest $request)
    {
        $data = $this->Repository->store($request->validated());
        if (isset($data->errorInfo)) {
            return $this->sendError($data->errorInfo, 'error', 404);
        } else {
            return $this->sendResponse($data, "تم تسجيل مشروعا جديدا", 200);
        }
    }



    public function show($id)
    {
        $data = $this->Repository->find($id);
        return $this->sendResponse(new ProjectResource($data), " ", 200);
    }


    public function update(Request $request ,$id)
    {
        $project = Sellproject::findOrFail($id);
        $user = Auth::User()->id ;
       
        return   $project->users; 

        $data = $this->Repository->edit($request ,$id);
        if (isset($data->errorInfo)) {
            return $this->sendError($data->errorInfo, 'error', 404);
        } else {
            return $this->sendResponse($data, "تم تعديل مشروعا جديدا", 200);
        }
        
    }



    public function destroy($id)
    {
        return $this->sendResponse($this->Repository->delete($id), " تم حذف المشروع ", 200);
    }
}
