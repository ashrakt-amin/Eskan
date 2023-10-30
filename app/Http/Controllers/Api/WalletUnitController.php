<?php

namespace App\Http\Controllers\Api;

use App\Models\Walletunit;
use Illuminate\Http\Request;
use App\Http\Requests\WalletUnitRequest;
use App\Http\Controllers\Controller;
use App\Http\Resources\Unit\WalletunitResource;
use Illuminate\Support\Facades\Auth;
use App\Repository\WalletUnits\WalletUnitInterface;
use App\Http\Traits\ResponseTrait as TraitResponseTrait;

class WalletUnitController extends Controller
{
    use TraitResponseTrait ;
    protected $Repository ;  
    
    public function __construct(WalletUnitInterface $Repository)
    {
        $this->Repository = $Repository;
    }
 
    public function index(Request $request)
    {
            return $this->Repository->forAllConditionsReturn($request->all(),WalletunitResource::class);
    }

    

    public function store(WalletUnitRequest $request)
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
        $data = Walletunit::findOrFail($id);
        return $this->sendResponse(new WalletunitResource($data), " ", 200);    }

    
    public function unit_update(Request $request,$id)
    {
         $data = $this->Repository->edit($id , $request);
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
