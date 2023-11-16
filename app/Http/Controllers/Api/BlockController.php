<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\WalletRequest;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\BlockResource;
use App\Models\Block;
use App\Http\Traits\ResponseTrait as TraitResponseTrait;

class BlockController extends Controller
{
  use TraitResponseTrait;
    
        public function index()
        {
                return BlockResource::collection(Block::all());     
        }
    
        public function store(WalletRequest $request)
        {
            $data = $this->Repository->store($request->validated());
            return $this->sendResponse($data, "تم التسجيل  ", 200);
        }
    
    
        public function show($id)
        {
            $data = $this->Repository->find($id);
            return $this->sendResponse(new WalletResource($data), " ", 200);
        }
    
    
        public function update(Request $request, $id)
        {
            $data = $this->Repository->edit($id, $request);
            return $this->sendResponse(new WalletResource($data), " تم تعديل ", 200);
        }
    
    
        public function destroy($id)
        {
            return $this->sendResponse($this->Repository->delete($id), " تم الحذف  ", 200);
        }
    
    
        public function forceDelete($id)
        {
            return $this->sendResponse($this->Repository->forceDelete($id), "force delete ", 200);
        }
    }
    