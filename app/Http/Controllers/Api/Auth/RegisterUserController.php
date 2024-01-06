<?php

namespace App\Http\Controllers\Api\auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Traits\ResponseTrait as TraitResponseTrait;


class RegisterUserController extends Controller
{
    use TraitResponseTrait ;
    public function register(Request $request)
    {
        $admin = Auth::user();
        if ($admin->role == 'admin') {
        $validatedData = $request->validate([
            'name'     => 'required|max:255',
            'password' => 'required|unique:users|min:6',
            'phone'    => 'required|unique:users',
            'role'    => 'required'

        ]);


        $user = new User();
        $user->name = $validatedData['name'];
        $user->password = Hash::make($validatedData['password']);
        $user->phone = $validatedData['phone'];
        $user->role = $validatedData['role'];


        $user->save();

        if($user){
        $success['token'] =  $user->createToken('user')->plainTextToken;
        $success['tokenName'] =  DB::table('personal_access_tokens')->orderBy('id', 'DESC')->select('name')->where(['tokenable_id'=>$user->id])->first();
        $success['name'] =  $user;
        return $this->sendResponse($success, 'تم التسجيل بنجاح.');
        } 
    } else {
        return response()->json([
            'message' => "unauthenticated",
        ], 422);
    }

    }
}
