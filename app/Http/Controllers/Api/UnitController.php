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
        $data = $this->Repository->store($request->validated());
        return $this->sendResponse($data, "    ", 200);

        if (isset($data->errorInfo)) {
            return $this->sendError($data->errorInfo, 'error', 404);
        } else {
            return $this->sendResponse('', "تم تسجيل وحده جديده بنجاح", 200);
        }
    }


    public function show($id)
    {
        $unit = $this->Repository->find($id);
        return $this->sendResponse(new UnitResource($unit), " ", 200);
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
            $unit = Unit::where('space', $space)->orderBy('meter_price', 'asc')->get();
        } else {
            $unit = Unit::orderBy('meter_price', 'asc')->get();
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




    public function levels($meter_price = 0, $space = 0)
    {
        if ($meter_price != 0 && $space != 0) {
            $unit = Unit::where('meter_price', $meter_price)->where('space', $space)
                ->orderBy('level_id', 'asc')->get();
        } elseif ($meter_price != 0 && $space == 0) {
            $unit = Unit::where('meter_price', $meter_price)
                ->orderBy('level_id', 'asc')->get();
        } elseif ($meter_price == 0 && $space != 0) {
            $unit = Unit::where('space', $space)
                ->orderBy('level_id', 'asc')->get();
        } else {
            $unit = Unit::all();
        }
        $unit_levels = $unit->unique('level_id')->pluck('level_id')->values()->all();
        $levels = Level::all();
        foreach ($unit_levels as $unit_level) {
            foreach ($levels as $level) {
                if ($level->id == $unit_level) {
                    $data[] = $level;
                }
            }
        }
        return response()->json([
            'status' => true,
            'message' => "unique level",
            'data' => $data
        ], 200);
    }



    public function numbers($level, $number)
    {
        $unit = Unit::where('level_id', $level)->where('number', $number)->first();
        if (isset($unit)) {
            return $this->sendResponse(new UnitResource($unit), " ", 200);
        } else {
            return $this->sendError("error", "unit not found ", 404);
        }
        //$numbers =$units->unique('number')->pluck('number')->values()->all();
    }
}
