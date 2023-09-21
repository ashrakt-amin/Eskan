<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\BazarCustomer;
use App\Http\Controllers\Controller;
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
      
            return $this->Repository->forAllConditionsReturn($request->all(), BazarCustomerResource::class);
    }

    

    public function store(BazarCustomerRequest $request)
    {
        $this->Repository->store($request->validated());
        return $this->sendResponse('', "تم التسجيل ", 200);
    }
    

  
    public function show($id)
    {
        return $this->sendResponse($this->Repository->find($id), " ", 200);
    }

    
    public function update(Request $request,$id)
    {
        return $this->sendResponse($this->Repository->edit($id , $request), " تم تعديل ", 200);

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
