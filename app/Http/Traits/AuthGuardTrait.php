<?php
namespace App\Http\Traits;
use Illuminate\Support\Facades\DB;

trait AuthGuardTrait {
    /**
     *  get token Row
     */
    public function getTokenRow() {
        if (request()->bearerToken() != null) {
            [$id, $user_token] = explode('|', request()->bearerToken(), 2);
            $token_data = DB::table('personal_access_tokens')->where('token', hash('sha256', $user_token))->first();
            return $token_data ;
        }
    }

    /**
     *  get token id
     */
    public function getTokenId($guard) {
        if (request()->bearerToken() != null) {
            $token_data = $this->getTokenRow();
            if ($token_data->name == $guard) {
                return $token_data->tokenable_id;
            }
        }
    }

    /**
     *  get token name
     */
    public function getTokenName($guard) {
        if (request()->bearerToken() != null) {
            $token_data = $this->getTokenRow();
            if ($token_data->name == $guard) {
                return $guard;
            }
        }
    }
}
