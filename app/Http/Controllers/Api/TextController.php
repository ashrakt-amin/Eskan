<?php

namespace App\Http\Controllers\Api;

use App\Models\Text;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\TextResource;
use App\Http\Traits\ResponseTrait as TraitResponseTrait;
use App\Http\Traits\ImageProccessingTrait as TraitImageProccessingTrait;


class TextController extends Controller
{
    use TraitResponseTrait, TraitImageProccessingTrait;

    public function index()
    {
        $text = Text::all();
        return $this->sendResponse(TextResource::collection($text), "all text", 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'         => 'required',
            'description'  => 'required',
            'img'          => 'nullable',
            'title'        => 'nullable'
        ]);

        if (isset($request['img']) && $request['img'] != "") {
            $img = $this->aspectForResize($request['img'], Text::IMAGE_PATH, 500, 600);
        } else {
            $img = null;
        }
        $data = Text::create([
            'name'        => $request->name,
            'description' => $request->description,
            'img'         => $img,
            'title'       => $request->title

        ]);
        
        return $this->sendResponse($data, "success", 200);
    }

    public function show($name)
    {
        $data = Text::where('name', $name)->get();
        return $this->sendResponse(TextResource::collection($data), "success", 200);
    }

    public function update(Request $request)
    {
        $data = Text::findOrFail($request->id);
        if (isset($request['img']) && $request['img'] != "") {
            $img = $this->aspectForResize($request['img'], Text::IMAGE_PATH, 500, 600);
            $this->deleteImage(Text::IMAGE_PATH,  $data->img);
            $data->update([
                'img'  =>  $img
            ]);
        } else {
            $data->update($request->all());
        }

        return $this->sendResponse($data, "update", 200);
    }


    public function destroy($id)
    {
        $data = Text::findOrFail($id);
        if ($data->img != null) {
            $this->deleteImage(Text::IMAGE_PATH,  $data->img);
        }
        $data->delete();
        return $this->sendResponse('', "delete", 200);
    }
}
