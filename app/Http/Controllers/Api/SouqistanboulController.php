<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\Souqistanboul;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\SouqistanboulRequest;
use App\Http\Resources\SouqistanboulResource;
use App\Http\Traits\ResponseTrait as TraitResponseTrait;
use App\Repository\Souqistanboul\SouqistanboulInterface;

class SouqistanboulController extends Controller
{
    use TraitResponseTrait;
    protected $Repository;


    public function __construct(SouqistanboulInterface $Repository)
    {
        $this->Repository = $Repository;
    }

    public function index(Request $request)
    {
        $role = Auth::user()->role;
        if (Auth::check() &&  ($role == "متابعه عملاء" || $role == "admin")) {
            return $this->Repository->forAllConditionsReturn($request->all(), SouqistanboulResource::class);
        } else {
            return $this->sendError('sorry', "you don't have permission to access this", 404);
        }
    }

    public function store(SouqistanboulRequest $request)
    {
        $data = Souqistanboul::create($request->validated());
        return $this->sendResponse($data, "تم التسجيل ", 200);
        }


    public function update(Request $request, $id)
    {
        return $this->sendResponse($this->Repository->edit($id, $request), " تم التعديل ", 200);
    }



    public function destroy($id)
    {
        return $this->sendResponse($this->Repository->delete($id), " تم الحذف  ", 200);
    }
}
