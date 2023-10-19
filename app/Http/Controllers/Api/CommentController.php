<?php

namespace App\Http\Controllers\Api;

use App\Models\Review;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\CommentRequest;
use App\Http\Resources\Social\CommentResource;
use App\Repository\Social\Comment\CommentInterface;
use App\Http\Traits\ResponseTrait as TraitResponseTrait;
use Illuminate\Support\Facades\Auth;


class CommentController extends Controller
{
    use TraitResponseTrait;
    protected $Repository;

    public function __construct(CommentInterface $Repository)
    {
        $this->Repository = $Repository;
    }

    public function index(Request $request)
    {
        return $this->Repository->forAllConditionsReturn($request->all(), CommentResource::class);
    }



    public function store(CommentRequest $request)
    {
      $data =  $this->Repository->store($request->validated());
        if (!isset($data->id)) {
            return $this->sendError($data, "لم يتم التسجيل", 404);
        } else {
            return $this->sendResponse($data, "تم تسجيل تعليق بنجاح", 200);
        }
    }


    public function show($id)
    {
        $data =  $this->Repository->find($id);
        return $this->sendResponse(new CommentResource($data), " ", 200);
    }



    public function update(Request $request, $id)
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
