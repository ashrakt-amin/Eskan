<?php

namespace App\Http\Controllers\Api\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use App\Http\Traits\ResponseTrait as TraitResponseTrait;
use App\Http\Traits\ImageProccessingTrait as TraitImageProccessingTrait;

class UpdateController extends Controller
{
    use TraitResponseTrait, TraitImageProccessingTrait;
    public function update(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        } else {
            return $request;
            if ($request['password'] ) {
                $user->update([
                    'password' => bcrypt($request['password']),
                ]);
            } elseif ($request['img']) {
                if ($user->img != NULL) {
                    $this->deleteImage(User::IMAGE_PATH, $user->img);
                }
                $user_img = $this->aspectForResize($request['img'], User::IMAGE_PATH, 500, 600);
                $user->update(['img' => $user_img]);
            }elseif ($request['phone']) {
                $request->validate([
                    'phone'     => ['required','regex:/^\d{7,}$/',Rule::unique('users')->ignore($user->phone)],
                ]);
                $user->update([
                    'phone' => $request['phone'],
                ]);
            }else {
                $user->update($request->all());
            }
        }
        $success['token']  = $user->createToken('token')->plainTextToken;

    return $this->sendResponse(new UserResource($user),"user data updated", 200 ,$success);
    }
}
