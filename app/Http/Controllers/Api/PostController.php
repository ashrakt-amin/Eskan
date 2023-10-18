<?php

namespace App\Http\Controllers\Api;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\PostRequest;
use App\Http\Resources\Social\postResource;
use App\Repository\Social\Post\PostInterface;
use App\Http\Traits\ResponseTrait as TraitResponseTrait;

class PostController extends Controller
{
    use TraitResponseTrait;
    protected $Repository;

    public function __construct(PostInterface $Repository)
    {
        $this->Repository = $Repository;
    }

    public function index(Request $request)
    {
      
        return $this->Repository->forAllConditionsReturn($request->all(), PostResource::class);
    }



    public function store(PostRequest $request)
    {
        // return $request ;

        $data =  $this->Repository->store($request->validated());
        if (!isset($data->id)) {
            return $this->sendError($data, "لم يتم التسجيل", 404);
        } else {
            return $this->sendResponse($data, "تم تسجيل بنجاح", 200);
        }
    }


    public function show($id)
    {
        $data =  $this->Repository->find($id);
        return $this->sendResponse(new PostResource($data), " ", 200);
    }



    public function postUpdate(Request $request, $id)
    {
        $data = $this->Repository->edit($request, $id);
        if (!isset($data->id)) {
            return $this->sendError("error", $data, 404);
        } else {
            return $this->sendResponse($data, " تم تعديل  ", 200);
        }
    }


    public function destroy($id)
    {
        $data = $this->Repository->delete($id);
        if ($data == true) {
            return $this->sendResponse('success', "تم حذف  ", 200);
        } else {
            return $this->sendError($data, "لم يتم حذف", 404);
        }
    }
}
