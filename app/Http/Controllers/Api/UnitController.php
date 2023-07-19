<?php

namespace App\Http\Controllers\Api;

use App\Models\Unit;
use App\Models\Level;
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
        return $this->sendResponse($this->Repository->edit($request), "تم التعديل ", 200);
    }


    public function storeImages(Request $request)
    {
        return $this->sendResponse($this->Repository->storeImages($request), "تم اضافه صور ", 200);
    }


    public function destroy($id)
    {
        return $this->sendResponse($this->Repository->delete($id), " تم حذف الوحده ", 200);
    }

    public function destroyImage($id)
    {
        return $this->sendResponse($this->Repository->deleteImageUnit($id), " تم حذف الوحده ", 200);
    }







    public function space($meter_price = '')
    {
        if ($meter_price != null && $meter_price != 0) {
            $spaces = Unit::where('meter_price', $meter_price)->orderBy('space', 'asc')->get();
        } else {
            $spaces = Unit::orderBy('space', 'asc')->get();
        }
        $unique_data = $spaces->unique('space')->pluck('space')
            ->values()->all();
        return response()->json([
            'status' => true,
            'message' => "unique spaces!",
            'data' => $unique_data
        ], 200);
    }


    public function meterPrice($space = '')
    {
        if ($space != null && $space != 0) {
            $meter_price = Unit::where('space', $space)->get();
        } else {
            $meter_price = Unit::all();
        }
        $unique_data = $meter_price->unique('meter_price')->pluck('meter_price')->values()->all();
        return response()->json([
            'status' => true,
            'message' => "unique meter price!",
            'data' => $unique_data
        ], 200);
    }




    public function levels()
    {
        $unit_level = Level::has('units')->get();
        return response()->json([
            'status' => true,
            'message' => "unique level",
            'data' => $unit_level
        ], 200);
    }
}
