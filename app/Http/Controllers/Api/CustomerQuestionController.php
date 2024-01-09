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

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (Auth::check() && (Auth::user()->role == 'سكرتاريه' || Auth::user()->role == 'admin')) {
                return $next($request);
            }
            abort(403, 'Unauthorized');
        });
    }


    public function index()
    {
        $role = Auth::user()->role;
        $data = CustomerQuestion::all();
        return $this->sendResponse(CustomerQuestionResource::collection($data), " ", 200);
    }


    public function store(CustomerQuestionRequest $request)
    {
        $data = CustomerQuestion::create($request->validated());
        return $this->sendResponse($data, "تم التسجيل ", 200);
    }

    public function update(CustomerQuestionRequest $request, $id)
    {
        $data = CustomerQuestion::findOrFail($id);
        $data->update($request->all());
        return $this->sendResponse($data, "تم التعديل ", 200);
    }

    public function destroy($id)
    {
        $role = Auth::user()->role;
        CustomerQuestion::findOrFail($id)->delete();
        return $this->sendResponse("success", "تم المسح ", 200);
    }
}
