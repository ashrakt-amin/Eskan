<?php

namespace App\Http\Controllers\Api;
use App\Http\Requests\OwnerRequest;
use App\Http\Controllers\Controller;
use App\Http\Resources\OwnerResource;
use App\Repository\Owners\OwnerInterface;
use App\Http\Traits\ResponseTrait as TraitResponseTrait;
use Illuminate\Http\Request;

class OwnerController extends Controller
    {
        use TraitResponseTrait ;
        protected $Repository ;  
    
        public function __construct(OwnerInterface $Repository)
        {
            $this->Repository = $Repository;
        }
    
        public function index(Request $request)
        {
            return $this->Repository->forAllConditionsReturn($request->all(), OwnerResource::class);

    
        }
    
        public function store(OwnerRequest $request)
        {
            $this->Repository->store($request->validated());
            return $this->sendResponse('', "تم التسجيل", 200);
        }
        
    
      
        public function show($id)
        {
            return $this->sendResponse($this->Repository->find($id), " ", 200);
        }
    
      
    }
    