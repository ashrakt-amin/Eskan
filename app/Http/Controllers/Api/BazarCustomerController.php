<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\BazarCustomer;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\BazarCustomerRequest;
use App\Http\Resources\BazarCustomerResource;
use App\Http\Traits\ResponseTrait as TraitResponseTrait;
use App\Repository\BazarCustomer\BazarCustomerInterface;

class BazarCustomerController extends Controller
{
    use TraitResponseTrait ;
    protected $Repository ;  
    

    public function __construct(BazarCustomerInterface $Repository)
    {
        $this->Repository = $Repository;
    }

    public function index(Request $request)
    {
        if(Auth::check() && Auth::user()->name == "متابعه عملاء"){
            return $this->Repository->forAllConditionsReturn($request->all(), BazarCustomerResource::class);
        }else{
            return $this->sendError('sorry', "you don't have permission to access this", 404);
        }
      
    }

    

    public function store(BazarCustomerRequest $request)
    {
       $data = $this->Repository->store($request->validated());
        if ($data === true){
            return $this->sendResponse($data, "تم", 200);
        } else {
            return $this->sendError($data, 'error', 404);
        }  
      }
    

  
    public function show($id)
    {
        return $this->sendResponse($this->Repository->find($id), " ", 200);
    }

    
    public function update(Request $request,$id)
    {
        $data = $this->Repository->edit($id , $request);
        if ($data === true){
            return $this->sendResponse($data, "تم التعديل ", 200);
        } else {
            return $this->sendError($data, 'error', 404);
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
