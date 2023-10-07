<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Repository\User\UserInterface;
use App\Http\Traits\ResponseTrait as TraitResponseTrait;

class UserController extends Controller
{
   
    use TraitResponseTrait ;
    protected $Repository ;  
    
    public function __construct(UserInterface $Repository)
    {
        $this->Repository = $Repository;
    }
 
    public function index(Request $request)
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
