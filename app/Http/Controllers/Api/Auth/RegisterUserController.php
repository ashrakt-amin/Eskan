<?php

namespace App\Http\Controllers\Api\auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Traits\ResponseTrait as TraitResponseTrait;
use App\Http\Traits\ImageProccessingTrait as TraitImageProccessingTrait;


class RegisterUserController extends Controller
{
    use TraitResponseTrait, TraitImageProccessingTrait;
    public function register(UserRequest $request)
    {
        DB::beginTransaction();
        try {
        $admin = Auth::user();
        // return $request->project_id ;
        if ($admin->role == 'admin' || $admin->role == "sales admin" || ($admin->role == "مسؤل مبيعات" && $admin->parent_ID == null) ) {
            $data =  $request->validated();
            if ($request->img != NULL) {
                $data['img'] = $this->aspectForResize($request['img'], User::IMAGE_PATH, 500, 600);
            }
            $data['password'] = Hash::make($data['password']);
            $user = User::create($data);

            if ($request->project_id) {
                $user->Sellprojects()->attach($request->project_id);
            }

            if ($user) {
                $success['token'] =  $user->createToken('user')->plainTextToken;
                $success['tokenName'] =  DB::table('personal_access_tokens')->orderBy('id', 'DESC')->select('name')->where(['tokenable_id' => $user->id])->first();
             
            } 
        }else{
            return response()->json([
                'message' => "unauthenticated",
            ], 422);    
        }
        DB::commit();
        return $this->sendResponse(new UserResource($user), 'تم التسجيل بنجاح.', 200, $success);
     } catch (\Exception $e) {
            return response()->json($e, 422);       
             }
        
    }
}
