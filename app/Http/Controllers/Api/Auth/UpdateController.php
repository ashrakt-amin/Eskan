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
        $auth = Auth::user();
        $user = User::findOrFail($request->user_id);
        if (!$auth) {
            return response()->json(['message' => 'you must be in users'], 404);
        } else {
            $request->validate([
                'phone'     => ['nullable', 'regex:/^\d{7,}$/', Rule::unique('users')->ignore($user->phone)],
                'name'      => ['nullable', Rule::unique('users')->ignore($user->name)],

            ]);
            if ($request['password']) {
                $user->update([
                    'password' => bcrypt($request['password']),
                ]);
            } elseif ($request['img']) {
                if ($user->img != NULL) {
                    $this->deleteImage(User::IMAGE_PATH, $user->img);
                }
                $user_img = $this->aspectForResize($request['img'], User::IMAGE_PATH, 500, 600);
                $user->update(['img' => $user_img]);
            } elseif ($request['phone']) {
                $user->update([
                    'phone' => $request['phone'],
                ]);
            } elseif ($request['role'] == NULL) {
                if ($auth->role == "admin") {
                    $user->update([
                        'role' => $request['role'],
                    ]);
                } else {
                    return response()->json(['message' => 'you must be admin'], 404);
                }
            } elseif ($request['project_id'] != NULL) {
                $user->Sellprojects()->sync($request->project_id);
            } elseif ($request['project_id'] == NULL) {
                $user->Sellprojects()->detach();
            } else {
                $user->update($request->all());
            }
        }
        $success['token']  = $user->createToken('token')->plainTextToken;

        return $this->sendResponse(new UserResource($user), "user data updated", 200, $success);
    }
}
