<?php

namespace App\Http\Controllers\Api;

use App\Models\Level;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\LevelResource;
use App\Http\Traits\ResponseTrait as TraitResponseTrait;

class LevelController extends Controller
{

    use  TraitResponseTrait ; 
    
    public function index()
    {
        $data = Level::all();
        return $this->sendResponse(LevelResource::collection($data) , " " ,200);

    }

  
    public function show($id)
    {
        $data = Level::findOrFail($id);
        return $this->sendResponse(new LevelResource($data), " ", 200);

    }
}
