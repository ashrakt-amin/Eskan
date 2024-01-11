<?php

namespace App\Http\Controllers\Api;

use App\Models\FormSell;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\FormSellRequest;
use App\Http\Traits\ResponseTrait as TraitResponseTrait;
use App\Http\Resources\sellsProfile\FormSellerdashResource;

class FormsellsController extends Controller
{
    use TraitResponseTrait;
  
    public function index()
    {
        //
    }

    public function store(FormSellRequest $request)
    {      
            $data = FormSell::create($request->validated());
            return $this->sendResponse(new FormSellerdashResource($data), "sells client", 200);
    }

    
    public function show(string $id)
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
