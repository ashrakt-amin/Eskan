<?php

namespace App\Http\Controllers\Api;

use App\Models\Unit;
use Illuminate\Http\Request;
use App\Http\Requests\UnitRequest;
use App\Http\Controllers\Controller;
use App\Repository\Units\UnitInterface;
use App\Http\Resources\Unit\UnitResource;
use App\Http\Traits\ResponseTrait as TraitResponseTrait;


class UnitController extends Controller
{
    use TraitResponseTrait;
    protected $Repository;

    public function __construct(UnitInterface $Repository)
    {
        $this->Repository = $Repository;
    }

    public function index(Request $request)
    {
        return $this->Repository->forAllConditionsReturn($request->all(), UnitResource::class);
    }



    public function store(UnitRequest $request)
    {
        $this->Repository->store($request->validated());
        return $this->sendResponse('', "تم تسجيل وحده جديده بنجاح", 200);
    }


    public function show($id)
    {
        return $this->sendResponse($this->Repository->find($id), " ", 200);

    }



    public function storeUp(Request $request)
    {
        return $this->sendResponse($this->Repository->edit($request), " تم تعديل الوحده ", 200);

    }


    public function destroy($id)
    {
        return $this->sendResponse($this->Repository->delete($id), " تم حذف الوحده ", 200);

    }
}
