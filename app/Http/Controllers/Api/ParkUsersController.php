<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\Parkuser;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ParkUserRequest;
use App\Http\Resources\ParkUserResource;
use App\Http\Traits\ResponseTrait as TraitResponseTrait;
use App\Repository\ParkUser\ParkUserInterface;

class ParkUsersController extends Controller
{
    use TraitResponseTrait;
    protected $Repository;


    public function __construct(ParkUserInterface $Repository)
    {
        $this->Repository = $Repository;
    }

    public function index(Request $request)
    {
        $name = Auth::user()->name;
        if (Auth::check() &&  $name == "متابعه عملاء" || $name == "admin") {
            return $this->Repository->forAllConditionsReturn($request->all(), ParkUserResource::class);
        } else {
            return $this->sendError('sorry', "you don't have permission to access this", 404);
        }
    }



    public function store(ParkUserRequest $request)
    {
        $this->Repository->store($request->validated());
        return $this->sendResponse('', "تم التسجيل ", 200);
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

    public function restore($id)
    {
        return $this->sendResponse($this->Repository->restore($id), " تم الاسترجاع  ", 200);
    }

    public function forceDelete($id)
    {
        return $this->sendResponse($this->Repository->forceDelete($id), "force delete ", 200);
    }
}