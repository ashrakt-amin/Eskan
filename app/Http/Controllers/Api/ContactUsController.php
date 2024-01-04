<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ContactRequest;
use App\Http\Resources\ContactResource;
use App\Repository\Contact\ContactInterface;
use App\Http\Traits\ResponseTrait as TraitResponseTrait;


class ContactUsController extends Controller
{
    use TraitResponseTrait;
    protected $Repository;


    public function __construct(ContactInterface $Repository)
    {
        $this->Repository = $Repository;
    }

    public function index(Request $request)
    {
        $role = Auth::user()->role;
        if (Auth::check() &&  ($role == "متابعه عملاء" || $role == "admin")) {
            return $this->Repository->forAllConditionsReturn($request->all(), ContactResource::class);
        } else {
            return $this->sendError('sorry', "you don't have permission to access this", 404);
        }
    }



    public function store(ContactRequest $request)
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


    public function forceDelete($id)
    {
        return $this->sendResponse($this->Repository->forceDelete($id), "force delete ", 200);
    }
}
