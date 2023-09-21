<?php

namespace App\Http\Controllers\Api;

use App\Models\Bazar;
use Illuminate\Http\Request;
use App\Http\Requests\BazarRequest;
use App\Http\Controllers\Controller;
use App\Repository\Bazar\BazarInterface;
use App\Http\Resources\Unit\BazarResource;
use App\Http\Traits\ResponseTrait as TraitResponseTrait;
use Mockery\Undefined;

class BazarController extends Controller
{
    use TraitResponseTrait;
    protected $Repository;

    public function __construct(BazarInterface $Repository)
    {
        $this->Repository = $Repository;
    }

    public function index(Request $request)
    {
        return $this->Repository->forAllConditionsReturn($request->all(), BazarResource::class);
    }



    public function store(BazarRequest $request)
    {
        $data = $this->Repository->store($request->validated());
        if (isset($data->id)) {
            return $this->sendResponse($data, "تم تسجيل وحده جديده بنجاح", 200);
        } else {
            return $this->sendError($data, 'error', 404);

        }
    }


    public function show($id)
    {
        $unit = $this->Repository->find($id);
        return $this->sendResponse(new BazarResource($unit), " ", 200);
    }


    public function storeUp(Request $request)
    {
        $data = $this->Repository->edit($request);
        if (isset($data->errorInfo)) {
            return $this->sendError($data->errorInfo, 'error', 404);
        } else {
            return $this->sendResponse('', "تم التعديل ", 200);
        }
    }



    public function destroy($id)
    {
        return $this->sendResponse($this->Repository->delete($id), " تم حذف الوحده ", 200);
    }



    public function space($meter_price = '')
    {
        if ($meter_price != null && $meter_price != 0) {
            $spaces = Bazar::where('meter_price', $meter_price)->orderBy('space', 'asc')->get();
        } else {
            $spaces = Bazar::orderBy('space', 'asc')->get();
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
            $unit = Bazar::where('space', $space)->orderBy('meter_price', 'asc')->get();
        } else {
            $unit = Bazar::orderBy('meter_price', 'asc')->get();
        }
        // $level = $unit->unique('level_id')
        // ->pluck('level_id')->values()->all();

        $unique_data = $unit->unique('meter_price')
            ->pluck('meter_price')->values()->all();

        return response()->json([
            'status' => true,
            'message' => "unique meter price!",
            'data' => $unique_data,
        ], 200);
    }








    public function numbers($level, $number)
    {
        $unit = Bazar::where('level_id', $level)->where('number', $number)->first();
        if (isset($unit)) {
            return $this->sendResponse(new BazarResource($unit), " ", 200);
        } else {
            return $this->sendError("error", "unit not found ", 404);
        }
        //$numbers =$units->unique('number')->pluck('number')->values()->all();
    }
}
