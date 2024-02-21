<?php

namespace App\Http\Controllers\Api;

use App\Models\Link;
use Illuminate\Http\Request;
use App\Http\Requests\LinkRequest;
use App\Http\Controllers\Controller;
use App\Http\Resources\LinkResource;
use App\Http\Traits\ResponseTrait as TraitResponseTrait;


class LinkController extends Controller
{
    use TraitResponseTrait;
    
    public function index()
    {
        $data = Link::all();
        return $this->sendResponse(LinkResource::collection($data), "كل اللينكات", 200);

    }


    public function show($id)
    {
        $data = Link::findOrFail($id);
        return $this->sendResponse($data, "تم", 200);
        
    }

    public function store(LinkRequest $request)
    {
        $data = Link::create($request->validated());
        return $this->sendResponse($data, "تم التسجيل  ", 200);
    }

   
    public function update(Request $request,$id)
    {
        $data = Link::findOrFail($id);
        $data->update($request->all());
        return $this->sendResponse($data, "تم التعديل  ", 200);

    }


    public function destroy($id)
    {
       $data = Link::findOrFail($id);
       $data->delete();
    }
}
