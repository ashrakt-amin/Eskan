<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\Userwallet;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\UserWalletRequest;
use App\Http\Resources\UseWalletResource;
use App\Http\Traits\ResponseTrait as TraitResponseTrait;
use App\Repository\UserWallet\UserWalletInterface;

class UserWalletController extends Controller
{
    use TraitResponseTrait;
    protected $Repository;


    public function __construct(UserWalletInterface $Repository)
    {
        $this->Repository = $Repository;
    }

    public function index(Request $request)
    {
        $name = Auth::user()->name;
        if (Auth::check() &&  $name == "متابعه عملاء" || $name == "admin") {
            return $this->Repository->forAllConditionsReturn($request->all(), UseWalletResource::class);
        } else {
            return $this->sendError('sorry', "you don't have permission to access this", 404);
        }
    }



    public function store(UserWalletRequest $request)
    {
        $data = $this->Repository->store($request->validated());
        if (!isset($data->id)) {
            return $this->sendError($data, 'error', 404);
        } else {
            return $this->sendResponse($data, "تم", 200);

        }
    }



    public function show($id)
    {
        return $this->sendResponse($this->Repository->find($id), " ", 200);
    }


    public function update(Request $request, $id)
    {
        $data = $this->Repository->edit($id, $request);
        if (!isset($data->id)){      
            return $this->sendError($data, 'error', 404);
           } else {
            return $this->sendResponse($data, "تم التعديل ", 200);
        }
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
