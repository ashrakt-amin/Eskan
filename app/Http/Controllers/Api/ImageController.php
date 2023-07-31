<?php

namespace App\Http\Controllers\Api;

use App\Models\Image;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Traits\ResponseTrait as TraitResponseTrait;
use App\Http\Traits\ImageProccessingTrait as TraitImageProccessingTrait;
use Illuminate\Validation\Rule;
use App\Http\Resources\ImageResource;





class ImageController extends Controller
{
    use TraitImageProccessingTrait, TraitResponseTrait;

    public function index()
    {
        $images = Image::all();
        return $this->sendResponse(ImageResource::collection($images), "all images", 200);


    }

    public function store(Request $request)
    {
        $request->validate([
            'image_name' => 'required|unique:images,name',
            'img'  => 'required'
        ]);

        $img = $this->aspectForResize($request['img'], 'Eskan', 500, 600);
        $image = Image::create([
            'name' => $request->image_name,
            'img'  => $img
        ]);
        return $this->sendResponse($image, "success", 200);
    }

    public function show($name)
    {
        $image = Image::where('name',$name)->first();
        return $this->sendResponse(new ImageResource($image), "success", 200);
    }

    public function updateImage(Request $request)
    {
        $image = Image::findOrFail($request->id);
        $request->validate([
            'id'         => 'required'
        ]);
        if ($request->img) {
            $this->deleteImage(Image::IMAGE_PATH, $image->img);
        }
        $img = $this->aspectForResize($request['img'], Image::IMAGE_PATH, 500, 600);
        $image->update([
            'img'  => $img
        ]);
        return $this->sendResponse($image, "update", 200);
    }


    public function destroy($id)
    {
        $image = Image::findOrFail($id);
        $this->deleteImage(Image::IMAGE_PATH, $image->img);
        $image->delete();
        return $this->sendResponse('', "delete", 200);

    }
}
