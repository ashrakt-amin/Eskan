<?php

namespace App\Http\Controllers\Api;

use App\Models\SeekMoney;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\SeekMoneyRequest;
use App\Http\Resources\SeekMoneyResource;
use App\Http\Traits\ResponseTrait as TraitResponseTrait;



class SeekMoneyController extends Controller

{
    use TraitResponseTrait;

    public function index()
    {
        $data = SeekMoney::all();
        return $this->sendResponse(SeekMoneyResource::collection($data), "", 200);
    }


    public function create()
    {
        //
    }

    public function store(SeekMoneyRequest $request)
    {
        SeekMoney::create($request->validated());
        return $this->sendResponse('', "تم التسجيل", 200);
    }


    public function show(string $id)
    {
        //
    }


    public function edit(string $id)
    {
        //
    }

    public function update(Request $request, string $id)
    {
        //
    }

    public function destroy($id)
    {
        SeekMoney::findOrFail($id)->delete();
        return $this->sendResponse('', " تم الحذف ", 200);
    }
}
