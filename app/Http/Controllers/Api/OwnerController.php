<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Requests\OwnerRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\OwnerResource;
use App\Repository\Owners\OwnerInterface;
use App\Http\Traits\ResponseTrait as TraitResponseTrait;

class OwnerController extends Controller
{
    use TraitResponseTrait;
    protected $Repository;

    public function __construct(OwnerInterface $Repository)
    {
        $this->Repository = $Repository;
    }

    public function index(Request $request)
    {
        $name = Auth::user()->name;
        if (Auth::check() &&  $name == "متابعه عملاء" || $name == "admin") {
            return $this->Repository->forAllConditionsReturn($request->all(), OwnerResource::class);
        } else {
            return $this->sendError('sorry', "you don't have permission to access this", 404);
        }
    }

    public function store(OwnerRequest $request)
    {
        $this->Repository->store($request->validated());
        return $this->sendResponse('', "تم التسجيل", 200);
    }



    public function show($id)
    {
        return $this->sendResponse($this->Repository->find($id), " ", 200);
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
