<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
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
        // $this->middleware(function ($request, $next) {
        //     if (Auth::check() && Auth::user()->name !== 'مدخل البيانات') {
        //         abort(403, 'Unauthorized');
        //     }
        // });
    }

    public function index(Request $request)
    {
        return $this->Repository->forAllConditionsReturn($request->all(), UnitImageResource::class);
    }



    public function store(Request $request)
    {
        $role = Auth::user()->role;
        if (Auth::check() &&  $role == "مدخل البيانات" || $role == "admin") {
            $data = $this->Repository->store($request->all());

            if ($data !== true) {
                return $this->sendError($data, 'error', 404);
            } else {
                return $this->sendResponse($data, "تم تسجيل بنجاح", 200);
            }
        } else {
            return $this->sendError('sorry', "you don't have permission to access this", 404);
        }
    }


    public function show($id)
    {
        $unit = $this->Repository->find($id);
        return $this->sendResponse(new UnitImageResource($unit), " ", 200);
    }


    public function storeUp(Request $request)
    {

        $role = Auth::user()->role;
        if (Auth::check() &&  $role == "مدخل البيانات" || $role == "admin") {
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



    public function destroy($id)
    {
        $role = Auth::user()->role;
        if (Auth::check() &&  $role == "مدخل البيانات" || $role == "admin") {
            $data = $this->Repository->delete($id);
            if (isset($data->errorInfo)) {
                return $this->sendError($data->errorInfo, 'error', 404);
            } else {
                return $this->sendResponse('', " تم حذف ", 200);
            }
        } else {
            return $this->sendError('sorry', "you don't have permission to access this", 404);
        }
    }
}
