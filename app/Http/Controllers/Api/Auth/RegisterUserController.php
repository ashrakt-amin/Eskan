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


        $validatedData = $request->validate([
            'name' => 'required|unique:users|max:255',
            'password' => 'required|unique:users|min:6',
            'phone'    => 'required|unique:users'
        ]);

        $user = new User();
        $user->name = $validatedData['name'];
        $user->password = Hash::make($validatedData['password']);
        $user->save();

        if($user){
        $success['token'] =  $user->createToken('admin')->plainTextToken;
        $success['tokenName'] =  DB::table('personal_access_tokens')->orderBy('id', 'DESC')->select('name')->where(['tokenable_id'=>$user->id])->first();
        $success['name'] =  $user;
        return $this->sendResponse($success, 'تم التسجيل بنجاح.');
       
    } else {
        return response()->json([
            'message' => "unauthenticated",
        ], 422);
    }

    }
}
