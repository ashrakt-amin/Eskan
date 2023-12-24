<?php

namespace App\Http\Controllers\api;

use Illuminate\Http\Request;
use App\Models\CustomerQuestion;
use App\Http\Controllers\Controller;
use App\Http\Requests\CustomerQuestionRequest;
use App\Http\Resources\CustomerQuestionResource;
use Illuminate\Support\Facades\Auth;
use App\Http\Traits\ResponseTrait as TraitResponseTrait;


class CustomerQuestionController extends Controller
{
    use TraitResponseTrait;

    public function index()
    {
        $name = Auth::user()->name;
        if (Auth::check() && ($name == "سكرتارية" || $name == "admin")) {
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
        $name = Auth::user()->name;
        if (Auth::check() && $name == "admin") {
            CustomerQuestion::findOrFail($id)->delete();
            return $this->sendResponse("success", "تم المسح ", 200);
        } else {
            return $this->sendError('sorry', "you don't have permission to access this", 404);
        }
    }
}
