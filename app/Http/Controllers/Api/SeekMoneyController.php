<?php

namespace App\Http\Controllers\Api;

use App\Models\SeekMoney;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\SeekMoneyRequest;
use App\Http\Resources\SeekMoneyResource;
use App\Repository\Contact\ContactInterface;
use App\Repository\SeekMoney\seekMoneyInterface;
use App\Http\Traits\ResponseTrait as TraitResponseTrait;



class SeekMoneyController extends Controller

{
    use TraitResponseTrait;

    public $Repository;
    public function __construct(seekMoneyInterface $Repository)
    {
        $this->Repository = $Repository;
    }


    public function index(Request $request)
    {
        return $this->Repository->forAllConditionsReturn($request->all(),SeekMoneyResource::class);

    }


    public function create()
    {
        //
    }

    public function store(SeekMoneyRequest $request)
    {
       $data = $this->Repository->store($request->validated());
        return $this->sendResponse($data, "تم التسجيل ", 200);
    }


    public function show(string $id)
    {
        //
    }


    public function update(Request $request, string $id)
    {
        //
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
