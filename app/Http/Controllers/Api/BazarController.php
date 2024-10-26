<?php

namespace App\Http\Controllers\Api;

use App\Models\Bazar;
use Mockery\Undefined;
use Illuminate\Http\Request;
use App\Http\Requests\BazarRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Repository\Bazar\BazarInterface;
use App\Http\Resources\Unit\BazarResource;
use App\Http\Traits\ResponseTrait as TraitResponseTrait;

class  BazarController extends Controller
{
    use TraitResponseTrait;
    protected $Repository;

    public function __construct(BazarInterface $Repository)
    {
        $this->Repository = $Repository;

        // $this->middleware(function ($request, $next) {
        //     if (Auth::check() && Auth::user()->name !== 'مدخل البيانات') {
        //         abort(403, 'Unauthorized');
        //     }

        //     return $next($request);
        // });

    }

    public function index(Request $request)
    {
        return $this->Repository->forAllConditionsReturn($request->all(), BazarResource::class);
    }



    public function store(BazarRequest $request)
    {
        $role = Auth::user()->role;
        if (Auth::check() && ($role == "مدخل البيانات " || $role == "admin")) {

            $data = $this->Repository->store($request->validated());
            if ($data == true) {
                return $this->sendResponse($data, "تم تسجيل وحده جديده بنجاح", 200);
            } else {
                return $this->sendError($data, 'error', 404);
            }
        } else {
            return $this->sendError('sorry', "you don't have permission to access this", 404);
        }
    }


    public function show($id)
    {
        $unit = $this->Repository->find($id);
        return $this->sendResponse(new BazarResource($unit), " ", 200);
    }


    public function storeUp(Request $request)
    {
        $role = Auth::user()->role;
        if (Auth::check() && ($role == "مدخل البيانات " || $role == "admin")) {
            $data = $this->Repository->edit($request);
            if ($data === true) {
                return $this->sendResponse($data, "تم التعديل ", 200);
            } else {
                return $this->sendError($data, 'error', 404);
            }
        } else {
            return $this->sendError('sorry', "you don't have permission to access this", 404);
        }
    }



    public function destroy($id)
    {
        $role = Auth::user()->role;
        if (Auth::check() && ($role == "مدخل البيانات " || $role == "admin")) {
            return $this->sendResponse($this->Repository->delete($id), " تم حذف الوحده ", 200);
        } else {
            return $this->sendError('sorry', "you don't have permission to access this", 404);
        }
    }




    public function numbers(Request $request)
    {
        //->where('section', $request['section'])

        $numbers = Bazar::orderBy('number', 'asc')->get();
        $unique_data = $numbers->unique('number')->pluck('number')
            ->values()->all();
        return response()->json([
            'status' => true,
            'message' => "unique numbers!",
            'data' => $unique_data
        ], 200);
    }


    public function revenue(Request $request)
    {

        $revenue = Bazar::orderBy('revenue', 'asc')->where('section', $request['section'])
            ->where('appear', 1)->get();
        $unique_data = $revenue->unique('revenue')->pluck('revenue')
            ->values()->all();
        return response()->json([
            'status' => true,
            'message' => "unique numbers!",
            'data' => $unique_data
        ], 200);
    }

    public function space($meter_price = '', Request $request)
    {
        if ($meter_price != null && $meter_price != 0) {
            $spaces = Bazar::where('meter_price', $meter_price)->where('section', $request['section'])
                ->where('appear', 1)->orderBy('space', 'asc')->get();
        } else {
            $spaces = Bazar::orderBy('space', 'asc')->where('section', $request['section'])
                ->where('appear', 1)->get();
        }
        $unique_data = $spaces->unique('space')->pluck('space')
            ->values()->all();
        return response()->json([
            'status' => true,
            'message' => "unique spaces!",
            'data' => $unique_data
        ], 200);
    }


    public function meterPrice(Request $request, $space = '')
    {
        if ($space != null && $space != 0) {
            $unit = Bazar::where('space', $space)->where('section', $request['section'])
                ->where('appear', 1)->orderBy('meter_price', 'asc')->get();
        } else {
            $unit = Bazar::orderBy('meter_price', 'asc')->where('section', $request['section'])
                ->where('appear', 1)->get();
        }

        $unique_data = $unit->unique('meter_price')
            ->pluck('meter_price')->values()->all();

        return response()->json([
            'status' => true,
            'message' => "unique meter price!",
            'data' => $unique_data,
        ], 200);
    }
}
