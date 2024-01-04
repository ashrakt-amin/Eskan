<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\WalletRequest;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\WalletResource;
use App\Repository\Wallet\WalletInterface;
use App\Http\Traits\ResponseTrait as TraitResponseTrait;


class WalletController extends Controller
{
    use TraitResponseTrait;
    protected $Repository;

    public function __construct(WalletInterface $Repository)
    {
        $this->Repository = $Repository;
    }

    public function index(Request $request)
    {
        $role = Auth::user()->role;
        if (Auth::check() &&  $role == "متابعه عملاء" || $role == "admin") {
            return $this->Repository->forAllConditionsReturn($request->all(), WalletResource::class);
        } else {
            return $this->sendError('sorry', "you don't have permission to access this", 404);
        }
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
