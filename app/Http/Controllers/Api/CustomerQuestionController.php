<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CustomerQuestion;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\CustomerQuestionRequest;
use App\Http\Resources\CustomerQuestionResource;
use App\Http\Traits\ResponseTrait as TraitResponseTrait;

class CustomerQuestionController extends Controller
{
    use TraitResponseTrait;

    public function index()
    {
        $role = Auth::user()->role;
        if (Auth::check() && ($role == "سكرتارية" || $role == "admin")) {
            $data = CustomerQuestion::all();
            return $this->sendResponse(CustomerQuestionResource::collection($data), " ", 200);
        } else {
            return $this->sendError('sorry', "you don't have permission to access this", 404);
        }
    }


    public function store(CustomerQuestionRequest $request)
    {
        $data = CustomerQuestion::create($request->validated());
        return $this->sendResponse($data, "تم التسجيل ", 200);
    }


    public function destroy($id)
    {
        $role = Auth::user()->role;
        if (Auth::check() && $role == "admin") {
            CustomerQuestion::findOrFail($id)->delete();
            return $this->sendResponse("success", "تم المسح ", 200);
        } else {
            return $this->sendError('sorry', "you don't have permission to access this", 404);
        }
    }
}
