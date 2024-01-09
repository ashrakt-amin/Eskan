<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;
use App\Repository\User\UserInterface;
use App\Http\Resources\UserAdminsResource;
use App\Http\Traits\ResponseTrait as TraitResponseTrait;

class UserController extends Controller
{
   
    use TraitResponseTrait ;
    protected $Repository ;  
    
    public function __construct(UserInterface $Repository)
    {
        $this->Repository = $Repository;
         $this->middleware(function ($request, $next) {
            if (Auth::check() && Auth::user()->role !== 'admin') {
                return $this->sendError('sorry', "you don't have permission to access this", 404);
            }else{
                return $next($request);

            }
        });

    }
 
    public function index(Request $request)
    {
            return $this->Repository->forAllConditionsReturn($request->all(),UserResource::class);
    }

    public function get_admins()
    {
        $data = User::where('parent_id',NULL)->get();
        return $this->sendResponse(UserAdminsResource::collection($data),"Users in company", 200);
    }

    public function get_sells(Request $request)
    {
            return $this->Repository->forAllConditionsReturn($request->all(),UserResource::class);
    }

    

    public function store(UserRequest $request)
    {
        $data = $this->Repository->store($request->validated());
        if (!isset($data->id)){
            return $this->sendError($data, 'error', 404);
        } else {
            return $this->sendResponse($data, "تم التسجيل ", 200);
        }
    }
    

  
    public function show($id)
    {
        return $this->sendResponse($this->Repository->find($id), " ", 200);
    }

    
    public function update(UserRequest $request,$id)
    {
         $data = $this->Repository->edit($id , $request->validated());
        if (!isset($data->id)){
            return $this->sendError($data, 'error', 404);
        } else {
            return $this->sendResponse($data,  " تم تعديل ",200);
        }

    }
  
  
    public function destroy($id)
    {
        return $this->sendResponse($this->Repository->delete($id), " تم الحذف  ", 200);

    }


}
