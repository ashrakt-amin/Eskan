<?php

namespace App\Http\Controllers\Api;

use App\Models\Reservation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\ReservationRequest;
use App\Http\Resources\ReservationResource;
use App\Repository\Reservation\ReservationInterface;
use App\Http\Traits\ResponseTrait as TraitResponseTrait;

class ReservationController extends Controller
{
    use TraitResponseTrait;
    protected $Repository;

    public function __construct(ReservationInterface $Repository)
    {
        $this->Repository = $Repository;
    }

    public function index(Request $request)
    {
        return $this->Repository->forAllConditionsReturn($request->all(), ReservationResource::class);
    }

    public function store(ReservationRequest $request)
    {
        $this->Repository->store($request->validated());
        return $this->sendResponse('', "تم التسجيل  ", 200);
    }


    public function show($id)
    {
        return $this->sendResponse($this->Repository->find($id), " ", 200);

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
