<?php

namespace App\Http\Controllers\Api;

use App\Models\Job;
use Illuminate\Http\Request;
use App\Http\Requests\JobRequest;
use App\Http\Resources\JobResource;
use App\Http\Controllers\Controller;
use App\Repository\Job\JobInterface;
use Illuminate\Support\Facades\Auth;
use App\Http\Traits\ResponseTrait as TraitResponseTrait;

class JobController extends Controller
{
    use TraitResponseTrait;
    protected $Repository;

    public function __construct(JobInterface $Repository)
    {
        $this->Repository = $Repository;
    }

    public function index(Request $request)
    {
        if(Auth::user()->name == "موارد بشريه"){
            return $this->Repository->forAllConditionsReturn($request->all(), JobResource::class);
        }else{
            return $this->sendResponse('sorry', "you don't have permission to access this", 404);
        }
    }



    public function store(JobRequest $request)
    {
        $data = $this->Repository->store($request->validated());
        if ($data == true){
            return $this->sendResponse($data, "تم التسجيل  بنجاح", 200);
        } else {
            return $this->sendError($data, 'error', 404);

        }
    }


    public function show($id)
    {
        $unit = $this->Repository->find($id);
        return $this->sendResponse(new JobResource($unit), " ", 200);
    }


    public function update($id,Request $request)
    {
        $data = $this->Repository->edit($id,$request);
        if ($data === true){
            return $this->sendResponse($data, "تم التعديل ", 200);
        } else {
            return $this->sendError($data, 'error', 404);
        }
    }



    public function destroy($id)
    {
        return $this->sendResponse($this->Repository->delete($id), " تم الحذف  ", 200);
    }



}



