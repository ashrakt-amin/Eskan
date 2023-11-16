<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\BlockRequest;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\BlockResource;
use App\Models\Block;
use App\Http\Traits\ResponseTrait as TraitResponseTrait;
use App\Http\Traits\ImageProccessingTrait as TraitImageProccessingTrait;


class BlockController extends Controller
{
  use TraitResponseTrait ,TraitImageProccessingTrait;
    
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
            $data = Block::findOrFail($id);
           
        }
    
    
        public function destroy($id)
        {
        }
    
    
    }
    