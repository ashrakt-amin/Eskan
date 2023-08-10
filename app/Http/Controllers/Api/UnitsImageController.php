<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Unit\UnitImageResource;
use App\Repository\UnitsImages\UnitImageInterface;
use App\Http\Traits\ResponseTrait as TraitResponseTrait;

class UnitsImageController extends Controller
{
    use TraitResponseTrait;
    protected $Repository;

    public function __construct(UnitImageInterface $Repository)
    {
        $this->Repository = $Repository;
    }

    public function index(Request $request)
    {
        return $this->Repository->forAllConditionsReturn($request->all(), UnitImageResource::class);
    }



    public function store(Request $request)
    {
        $data = $this->Repository->store($request->all());

        if ($data !== true) {
            return $this->sendError($data, 'error', 404);
        } else {
            return $this->sendResponse($data, "تم تسجيل بنجاح", 200);
        }
    }


    public function show($id)
    {
        $unit = $this->Repository->find($id);
        return $this->sendResponse(new UnitImageResource($unit), " ", 200);
    }


    public function storeUp(Request $request)
    {
        $data = $this->Repository->edit($request);
        if (isset($data->errorInfo)) {
            return $this->sendError($data->errorInfo, 'error', 404);
        } else {
            return $this->sendResponse($data, "تم التعديل ", 200);
        }
    }



    public function destroy($id)
    {
        return $this->sendResponse($this->Repository->delete($id), " تم حذف ", 200);
    }


  
}
