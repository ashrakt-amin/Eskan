<?php

namespace App\Http\Controllers\Api;

use App\Models\Visitor;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\VisitorRequest;
use App\Http\Resources\VisitorResource;
use App\Http\Traits\ResponseTrait as TraitResponseTrait;

class VisitorController extends Controller
{
    use TraitResponseTrait;

    public function index()
    {
        $data = Visitor::all();
        return $this->sendResponse(VisitorResource::collection($data), "كل الزوار", 200);
    }


    public function show($id)
    {
        $data = Visitor::findOrFail($id);
        return $this->sendResponse(new VisitorResource($data), "تم", 200);
    }

    public function store(VisitorRequest $request)
    {
        $data = Visitor::create($request->validated());
        return $this->sendResponse($data, "تم التسجيل  ", 200);
    }


    public function update(Request $request, $id)
    {
        $data = Visitor::findOrFail($id);
        $data->update($request->all());
        return $this->sendResponse($data, "تم التعديل  ", 200);
    }


    public function destroy($id)
    {
        $data = Visitor::findOrFail($id);
        $data->delete();
        return $this->sendResponse('success', "تم التعديل  ", 200);

    }
}