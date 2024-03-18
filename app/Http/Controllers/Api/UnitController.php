<?php

namespace App\Http\Controllers\Api;

use App\Models\Unit;
use App\Models\Level;
use Illuminate\Http\Request;
use App\Http\Requests\UnitRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Repository\Units\UnitInterface;
use App\Http\Requests\CommericalRequest;
use App\Http\Resources\Unit\UnitResource;
use App\Http\Resources\Unit\CommercialResource;
use App\Http\Traits\ResponseTrait as TraitResponseTrait;


class UnitController extends Controller
{
    use TraitResponseTrait;
    protected $Repository;

    public function __construct(UnitInterface $Repository)
    {
        $this->Repository = $Repository;

        // $this->middleware(function ($request, $next) {
        //     if (Auth::check() && Auth::user()->name !== 'مدخل البيانات') {
        //         abort(403, 'Unauthorized');
        //     }
        // });

    }

    public function index(Request $request)
    {
    //   return $request['type'] ;
        if ( $request['type'] == "سكنى") {
            return $this->Repository->forAllConditionsReturn($request->all(), UnitResource::class);
        } elseif ( $request['type'] == "تجارى") {
            return $this->Repository->forAllConditionsReturn($request->all(), CommercialResource::class);
        }
    }


    //سكنى
    public function store(UnitRequest $request)
    {
        $role = Auth::user()->role;
        if (Auth::check() && ($role == "مدخل البيانات" || $role == "admin")) {
            $data = $this->Repository->store($request->validated());
            if (!isset($data->id)) {
                return $this->sendError($data, 'error', 404);
            } else {
                return $this->sendResponse($data, "تم تسجيل وحده جديده بنجاح", 200);
            }
        } else {
            return $this->sendError('sorry', "you don't have permission to access this", 404);
        }
    }

    //تجارى
    public function storeCommercial(CommericalRequest $request)
    {
        $role = Auth::user()->role;
        if (Auth::check() && ($role == "مدخل البيانات" || $role == "admin")) {
            $data = $this->Repository->storeCommerical($request->validated());
            if (!isset($data->id)) {
                return $this->sendError($data, 'error', 404);
            } else {
                return $this->sendResponse(new CommercialResource($data), "تم تسجيل وحده تجاريه جديده بنجاح", 200);
            }
        } else {
            return $this->sendError('sorry', "you don't have permission to access this", 404);
        }
    }


    public function show($id)
    {
        $unit = $this->Repository->find($id);
        return $this->sendResponse(new UnitResource($unit), " ", 200);
    }


    public function storeUp(Request $request)
    {
        $role = Auth::user()->role;
        if (Auth::check() && ($role == "مدخل البيانات " || $role == "admin")) {
            $data = $this->Repository->edit($request);
            if (isset($data->errorInfo)) {
                return $this->sendError($data->errorInfo, 'error', 404);
            } else {
                return $this->sendResponse($data, "تم التعديل ", 200);
            }
        } else {
            return $this->sendError('sorry', "you don't have permission to access this", 404);
        }
    }


    public function commercialUpdate(Request $request)
    {
        $role = Auth::user()->role;
        if (Auth::check() && ($role == "مدخل البيانات " || $role == "admin")) {
            $data = $this->Repository->editCommercial($request);
            if (isset($data->errorInfo)) {
                return $this->sendError($data->errorInfo, 'error', 404);
            } else {
                return $this->sendResponse(new CommercialResource($data), "تم التعديل ", 200);
            }
        } else {
            return $this->sendError('sorry', "you don't have permission to access this", 404);
        }
    }


    public function storeImages(Request $request)
    {
        $role = Auth::user()->role;
        if (Auth::check() && ($role == "مدخل البيانات " || $role == "admin")) {
            $data = $this->Repository->storeImages($request);
            if (isset($data->errorInfo)) {
                return $this->sendError($data->errorInfo, 'error', 404);
            } else {
                return $this->sendResponse('', "تم اضافه صور ", 200);
            }
        } else {
            return $this->sendError('sorry', "you don't have permission to access this", 404);
        }
    }


    public function destroy($id)
    {
        $role = Auth::user()->role;
        if (Auth::check() && ($role == "مدخل البيانات " || $role == "admin")) {
            $data = $this->Repository->delete($id);
            if (isset($data->errorInfo)) {
                return $this->sendError($data->errorInfo, 'error', 404);
            } else {
                return $this->sendResponse(' ', " تم حذف الوحده ", 200);
            }
        } else {
            return $this->sendError('sorry', "you don't have permission to access this", 404);
        }
    }

    public function destroyImage($id)
    {
        $role = Auth::user()->role;
        if (Auth::check() &&  $role == "مدخل البيانات " || $role == "admin") {
            $data = $this->Repository->deleteImageUnit($id);
            if (isset($data->errorInfo)) {
                return $this->sendResponse(' ', " تم حذف الوحده ", 200);
            } else {
                return $this->sendResponse(' ', " تم حذف الوحده ", 200);
            }
        } else {
            return $this->sendError('sorry', "you don't have permission to access this", 404);
        }
    }

    //start filter method ------------------------

    public function meterPrice(Request $request)
    {
        $q = Unit::query();
        $attributes = $request->all();
        $type = $attributes['type'];
        $q->where('appear',1)->whereHas('type', function ($query) use ($type) {
            $query->where('name', $type);
        })->get();

        if (array_key_exists('space', $attributes) && $attributes['space'] != 0) {
            $q->where(['space' => $attributes['space']]);
        }

        if (array_key_exists('block_id', $attributes) && $attributes['block_id'] != 0) {
            $q->where(['block_id' => $attributes['block_id']]);
        }

        if (array_key_exists('level_id', $attributes) && $attributes['level_id'] != 0) {
            $q->where(['level_id' => $attributes['level_id']]);
        }

        if (array_key_exists('number', $attributes) && $attributes['number'] != 0) {
            $q->where(['number' => $attributes['number']]);
        }

        if ((!array_key_exists('space', $attributes) || $attributes['space'] == 0) &&
            (!array_key_exists('block_id', $attributes) || $attributes['block_id'] == 0) &&
            (!array_key_exists('level_id', $attributes) || $attributes['level_id'] == 0)&&
            (!array_key_exists('number', $attributes) || $attributes['number'] == 0) 
        ) {
            // $unit = Unit::all();
            $unit  = Unit::where('appear',1)->whereHas('type', function ($query) use ($type) {
                $query->where('name', $type);
            })->get();

            $response = $unit->unique('meter_price')->pluck('meter_price')->values()->all();
            $unique_data = collect($response)->sortBy(function ($item) {
                return $item;
            })->values()->all();
            return response()->json([
                'status' => true,
                'message' => "unique meter_price!",
                'data' => $unique_data
            ], 200);
        }
        $response = $q->orderBy('meter_price', 'asc')->pluck('meter_price')->unique()->values()->all();

        $meter_price = collect($response)->sortBy(function ($item) {
            return $item;
        })->values()->all();

        return response()->json([
            'status' => true,
            'message' => "unique meter_price!",
            'data' => $meter_price
        ], 200);
    }

    public function space(Request $request)
    {
        $q = Unit::query();
        $attributes = $request->all();
        $type = $attributes['type'];
        $q->where('appear',1)->whereHas('type', function ($query) use ($type) {
            $query->where('name', $type);
        })->get();

        if (array_key_exists('meter_price', $attributes) && $attributes['meter_price'] != 0) {
            $q->where(['meter_price' => $attributes['meter_price']]);
        }

        if (array_key_exists('block_id', $attributes) && $attributes['block_id'] != 0) {
            $q->where(['block_id' => $attributes['block_id']]);
        }

        if (array_key_exists('level_id', $attributes) && $attributes['level_id'] != 0) {
            $q->where(['level_id' => $attributes['level_id']]);
        }

        if (array_key_exists('number', $attributes) && $attributes['number'] != 0) {
            $q->where(['number' => $attributes['number']]);
        }

        if ((!array_key_exists('meter_price', $attributes) || $attributes['meter_price'] == 0) &&
            (!array_key_exists('block_id', $attributes) || $attributes['block_id'] == 0) &&
            (!array_key_exists('level_id', $attributes) || $attributes['level_id'] == 0) &&
            (!array_key_exists('number', $attributes) || $attributes['number'] == 0) 
        ) {

            $unit  = Unit::where('appear',1)->whereHas('type', function ($query) use ($type) {
                $query->where('name', $type);
            })->get();
            $response = $unit->unique('space')->pluck('space')->values()->all();
            $unique_data = collect($response)->sortBy(function ($item) {
                return $item;
            })->values()->all();
            return response()->json([
                'status' => true,
                'message' => "unique space!",
                'data' => $unique_data
            ], 200);
        }
        $response = $q->orderBy('space', 'asc')->pluck('space')->values()->unique()->all();
        $spaces = collect($response)->sortBy(function ($item) {
            return $item;
        })->values()->all();

        return response()->json([
            'status' => true,
            'message' => "unique spaces!",
            'data' => $spaces
        ], 200);
    }


    public function levels(Request $request)
    {
        $q = Unit::query();
        $attributes = $request->all();
        $type = $attributes['type'];
        $q->where('appear',1)->whereHas('type', function ($query) use ($type) {
            $query->where('name', $type);
        })->get();

        if (array_key_exists('meter_price', $attributes) && $attributes['meter_price'] != 0) {
            $q->where(['meter_price' => $attributes['meter_price']]);
        }

        if (array_key_exists('block_id', $attributes) && $attributes['block_id'] != 0) {
            $q->where(['block_id' => $attributes['block_id']]);
        }

        if (array_key_exists('space', $attributes) && $attributes['space'] != 0) {
            $q->where(['space' => $attributes['space']]);
        }

        if (array_key_exists('number', $attributes) && $attributes['number'] != 0) {
            $q->where(['number' => $attributes['number']]);
        }

        if ((!array_key_exists('meter_price', $attributes) || $attributes['meter_price'] == 0) &&
            (!array_key_exists('block_id', $attributes) || $attributes['block_id'] == 0) &&
            (!array_key_exists('space', $attributes) || $attributes['space'] == 0) &&
            (!array_key_exists('number', $attributes) || $attributes['number'] == 0) 
        ) {

            $unit  = Unit::where('appear',1)->whereHas('type', function ($query) use ($type) {
                $query->where('name', $type);
            })->get();
            if(count($unit) >1){
                $response = $unit->unique('level_id')->pluck('level_id')->values()->all();
         
                if($unit == null){
                    $data = [];
                }
                $unit_levels = collect($response)->sortBy(function ($item) {
                    return $item;
                })->values()->all();
    
                $levels = Level::all();
                foreach ($unit_levels as $unit_level) {
                    foreach ($levels as $level) {
                        if ($level->id == $unit_level) {
                            $data[] = $level;
                        }
                    }
                }
            }else{
                $data = [];
            }
           
           

            return response()->json([
                'status' => true,
                'message' => "unique level",
                'data' => $data
            ], 200);
        }

        $unit_levels = $q->orderBy('level_id', 'asc')->pluck('level_id')->values()->unique()->all();
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


    //end filter ------------------------------------


    public function spaces($meter_price = 0)
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
    public function level($meter_price = 0, $space = 0)
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

    public function block_space($block_id = 0, $meter_price = 0)
    {
        if ($meter_price != 0 && $block_id != 0) {
            $units = Unit::where('meter_price', $meter_price)->Where('block_id', $block_id)
                ->orderBy('space', 'asc')->get();
        } elseif ($meter_price == 0 && $block_id != 0) {
            $units = Unit::where('block_id', $block_id)->orderBy('space', 'asc')->get();
        } elseif ($meter_price != 0 && $block_id == 0) {
            $units = Unit::where('meter_price', $meter_price)->orderBy('space', 'asc')->get();
        } else {
            $units = Unit::all();
        }
        $unique_data = $units->unique('space')->pluck('space')->values()->all();
        return response()->json([
            'status' => true,
            'message' => "unique spaces!",
            'data' => $unique_data
        ], 200);
    }

    public function block_meter_price($block_id = 0, $space = 0)
    {
        if ($space != 0 && $block_id != 0) {
            $units = Unit::where('space', $space)->Where('block_id', $block_id)
                ->orderBy('meter_price', 'asc')->get();
        } elseif ($space == 0 && $block_id != 0) {
            $units = Unit::where('block_id', $block_id)->orderBy('meter_price', 'asc')->get();
        } elseif ($space != 0 && $block_id == 0) {
            $units = Unit::where('space', $space)->orderBy('meter_price', 'asc')->get();
        } else {
            $units = Unit::all();
        }
        $unique_data = $units->unique('meter_price')->pluck('meter_price')->values()->all();
        return response()->json([
            'status' => true,
            'message' => "unique meter_price!",
            'data' => $unique_data
        ], 200);
    }






    // if(count($units) > 0){
    // $levels = Level::all();
    // foreach ($units as $unit) {
    //     foreach ($levels as $level) {
    //         if ($level->id == $unit) {
    //             $data[] = $level;
    //         }
    //     }
    // }
    //     return response()->json([
    //                 'status' => true,
    //                 'message' => "unique level",
    //                 'data' => $data
    //             ], 200);
    //         }


    // public function block_levels($block_id = 0 , $space = 0 ,$meter_price = 0)
    // {
    // if ($meter_price != 0 && $space != 0 && $block_id != 0) {
    //     $unit = Unit::where('block_id', $block_id)->where('space', $space)->where('meter_price', $meter_price)
    //         ->orderBy('level_id', 'asc')->get();
    // } elseif ($block_id == 0 && $space == 0 && $meter_price != 0) {
    //     $unit = Unit::where('block_id', $block_id)->where('meter_price', $meter_price)
    //         ->orderBy('level_id', 'asc')->get();
    // } elseif ($meter_price == 0 && $space != 0) {
    //     $unit = Unit::where('block_id', $block_id)->where('space', $space)
    //         ->orderBy('level_id', 'asc')->get();
    // } elseif ($block_id == 0 && $space != 0 && $meter_price != 0) {
    //     $unit = Unit::where('space', $space)->where('meter_price', $meter_price)
    //         ->orderBy('level_id', 'asc')->get();
    // } elseif ($block_id != 0 && $space == 0 && $meter_price == 0) {
    //     $unit = Unit::where('block_id', $block_id)
    //         ->orderBy('level_id', 'asc')->get();
    // } else {
    //     $unit = Unit::all();
    // }


    //         $unit = Unit::where('block_id', $block_id)->where('space', $space)->where('meter_price', $meter_price)
    //             ->orderBy('level_id', 'asc')->get();


    //     $unit_levels = $unit->unique('level_id')->pluck('level_id')->values()->all();
    //     if(count($unit_levels) > 0){
    //     $levels = Level::all();
    //     foreach ($unit_levels as $unit_level) {
    //         foreach ($levels as $level) {
    //             if ($level->id == $unit_level) {
    //                 $data[] = $level;
    //             }
    //         }
    //     }
    //     return response()->json([
    //         'status' => true,
    //         'message' => "unique level",
    //         'data' => $data
    //     ], 200);
    // }else{
    //     return response()->json([
    //         'status' => true,
    //         'message' => "error data",
    //         'data' => ''
    //     ], 404);
    // }

    // }


    public function block_number($block_id, $number)
    {
        $unit = Unit::where('block_id', $block_id)->where('number', $number)->first();
        if (isset($unit)) {
            return $this->sendResponse(new UnitResource($unit), " ", 200);
        } else {
            return $this->sendError("error", "unit not found ", 404);
        }
        //$numbers =$units->unique('number')->pluck('number')->values()->all();
    }
}
