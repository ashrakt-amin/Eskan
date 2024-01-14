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

    public function updateImage(Request $request)
    {
        $auth = Auth::user();
        $user = User::findOrFail($request->user_id);
        if (!$auth) {
            return response()->json(['message' => 'you must be in users'], 404);
        } else {
            if ($request['img'] != "null") {
                $this->deleteImage(User::IMAGE_PATH, $user->img);
                $user_img = $this->aspectForResize($request['img'], User::IMAGE_PATH, 500, 600);
                $user->update(['img' => $user_img]);
            } else {
                $this->deleteImage(User::IMAGE_PATH, $user->img);
                $user->update(['img' => null]);
            }
        }
        return $this->sendResponse(new UserResource($user), "user data updated", 200);
    }


    public function update(Request $request, $id)
    {
        $auth = Auth::user();
        $user = User::findOrFail($id);
        if (!$auth) {
            return response()->json(['message' => 'you must be in users'], 404);
        } else {
            $request->validate([
                'phone'     => ['regex:/^\d{7,}$/', 'required', Rule::unique('users')->ignore($user->id),],
                'name'      => [Rule::unique('users')->ignore($user->id)],
            ]);
            // return $request->project_id ;

            $user->update($request->all());
            $user->Sellprojects()->sync($request['project_id']);
        }
        // $success['token']  = $user->createToken('token')->plainTextToken;

        return $this->sendResponse(new UserResource($user), "user data updated", 200);
    }
}
