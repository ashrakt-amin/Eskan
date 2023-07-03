<?php

namespace App\Http\Controllers\Api\auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Laravel\Sanctum\PersonalAccessToken;

class LogoutController extends Controller
{
    public function logout(Request $request)
    {
        $logout = PersonalAccessToken::findToken($request->bearerToken())->delete();
        if ($logout) {
            return response()->json([
                'message' => 'تم تسجيل الخروج',
            ], );
        } else {
            return response()->json([
                'message' => 'فشل تسجيل الخروج',
            ], );
        }
    }
}
