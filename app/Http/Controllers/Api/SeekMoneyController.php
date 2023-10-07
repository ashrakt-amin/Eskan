<?php

namespace App\Http\Controllers\Api;

use App\Models\SeekMoney;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
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
        if(Auth::check() && Auth::user()->name == "متابعه عملاء"){
            return $this->Repository->forAllConditionsReturn($request->all(), SeekMoneyResource::class);
        }else{
            return $this->sendError('sorry', "you don't have permission to access this", 404);
        }
    }

    public function store(SeekMoneyRequest $request)
    {
        $data = $this->Repository->store($request->validated());
        return $this->sendResponse($data, "تم التسجيل ", 200);
    }



    public function update(Request $request, $id)
    {
        return $this->sendResponse($this->Repository->edit($id, $request), " تم تعديل ", 200);
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
