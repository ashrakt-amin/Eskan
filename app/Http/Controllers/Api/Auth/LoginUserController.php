<?php

namespace App\Http\Controllers\Api\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Traits\ResponseTrait as TraitResponseTrait;
use App\Http\Traits\AuthGuardTrait as TraitResponseAuth;

class LoginUserController extends Controller
{
    use TraitResponseTrait, TraitResponseAuth;

    public function login(Request $request)
    {
        $credentials = $request->only(['password', 'phone']);

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
                $success['token']  = $user->createToken('token')->plainTextToken;
                $success['name']      = $user;
            

            return $this->sendResponse($success, 'تم تسجيل الدخول بنجاح.', 200);
        } else {
            return $this->sendError('Unauthorised.', ['error' => 'بيانات غير صحيحة'], 401);
        }
    }

    public function show()
    {
        // $id = Auth::user()->id;
        // return $id ;

        if (Auth::user()) {
            return response()->json([
                'data' => 'true'
            ], 200);
        } else {
            return response()->json([
                'data' => 'false'
            ], 500);
        }
    }
}
