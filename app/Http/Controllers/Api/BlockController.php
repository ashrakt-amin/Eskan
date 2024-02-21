<?php

namespace App\Http\Controllers\Api;

use App\Models\Block;
use Illuminate\Http\Request;
use App\Http\Requests\BlockRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\BlockResource;
use App\Http\Traits\ResponseTrait as TraitResponseTrait;
use App\Http\Traits\ImageProccessingTrait as TraitImageProccessingTrait;


class BlockController extends Controller
{
    use TraitResponseTrait, TraitImageProccessingTrait;

    public function index()
    {
        return BlockResource::collection(Block::all());
    }

    public function store(BlockRequest $request)
    {
        $attributes = $request->validated();
        $attributes['img'] = $this->aspectForResize($attributes['img'], Block::IMAGE_PATH, 500, 600);

        $data = Block::create($attributes);
        return $this->sendResponse($data, "تم التسجيل  ", 200);
    }


    public function show($id)
    {
        $data = Block::findOrFail($id);
        return $this->sendResponse(new BlockResource($data), " ", 200);
    }


    public function update(Request $request, $id)
    {
        $block = Block::findOrFail($id);
        if ($request['img']) {
            $this->deleteImage(Block::IMAGE_PATH, $block->img);
            $img = $this->aspectForResize($request['img'], Block::IMAGE_PATH, 500, 600);
            $block->update(['img' => $img]);
        } else {
            $block->update($request->all());
        }
        return $this->sendResponse(new BlockResource($block), " ", 200);
    }


    public function destroy($id)
    {
        $block = Block::findOrFail($id);
        $this->deleteImage(Block::IMAGE_PATH, $block->img);
        $block->delete();
        return $this->sendResponse('', " تم المسح", 200);
    }
}
