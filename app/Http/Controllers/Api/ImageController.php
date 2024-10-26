<?php

namespace App\Http\Controllers\Api;

use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use App\Http\Resources\ImageResource;
use App\Http\Resources\ImagenameResource;
use App\Http\Traits\ResponseTrait as TraitResponseTrait;
use App\Http\Traits\ImageProccessingTrait as TraitImageProccessingTrait;





class ImageController extends Controller
{
    use TraitImageProccessingTrait, TraitResponseTrait;

    public function index()
    {
        $images = Image::all();
        return $this->sendResponse(ImageResource::collection($images), "all images", 200);
    }


    public function uniqueNames()
    {
        $uniqueNames = Image::select('name')->distinct()->pluck('name');
        return $this->sendResponse($uniqueNames, "unique Names", 200);
    }


    

    public function store(Request $request)
    {
        $request->validate([
            'image_name' => 'required',
            'img'  => 'required'
        ]);

        $img =  $request['img'];
        $img_name = date('YmdHi') . $img->getClientOriginalName();
        $img->move(storage_path('app/public/images/'. Image::IMAGE_PATH ), $img_name);

        $image = Image::create([
            'name' => $request->image_name,
            'img'  => $img_name
        ]);
        
        return $this->sendResponse($image, "success", 200);
    }

    public function show($name)
    {
        // $image = Image::where('name', 'like', '%' . $name . '%')->get();
        // return $this->sendResponse(ImageResource::collection($image), "success", 200);

        $image = Image::where('name', $name)->get();
        if($image->count() > 1){
            return $this->sendResponse(ImageResource::collection($image), "success", 200);

        }else{
            return $this->sendResponse(new ImageResource($image->first()), "success", 200);

        }
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

    public function updateNames(Request $request)
    {
        // Update images with the old name to the new name
        $updatedImages = Image::where('name', $request->input('old_name'))
                               ->update(['name' => $request->input('new_name')]);

        if ($updatedImages) {
            return $this->sendResponse('true', "update names", 200);
        } else {
            return $this->sendError('false', "No images found with the provided name", 422);
        } 
    }


    public function destroy($id)
    {
        $image = Image::findOrFail($id);
        $this->deleteImage(Image::IMAGE_PATH, $image->img);
        $image->delete();
        return $this->sendResponse('', "delete", 200);

    }
}
