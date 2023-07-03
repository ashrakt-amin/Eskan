<?php

namespace App\Http\Controllers\Api;

use App\Models\UnitsType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Unit\unitTypeResource;
use App\Http\Traits\ResponseTrait as TraitResponseTrait;


class unitsTypeController extends Controller
{
    use  TraitResponseTrait ; 
    
    public function index()
    {
        $data = UnitsType::all();
        return $this->sendResponse(unitTypeResource::collection($data) , " " ,200);

    }

  
    public function store(Request $request)
    {
        //
    }

    public function update(Request $request, string $id)
    {
        //
    }

    
    public function destroy(string $id)
    {
        //
    }
}
