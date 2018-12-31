<?php

namespace App\Http\Controllers\Api\Auth;

use App\Role;
use App\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Lcobucci\JWT\Parser;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    public function login(Request $request)
    {
        $this->validateLogin($request);

        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            $this->sendLockoutResponse($request);

            return $this->sendFailedLoginResponse($request);
        }

        if ($this->attemptLogin($request)) {
            $response = $this->sendLoginResponse($request);

            return $response;
        }

        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }

    protected function sendLoginResponse(Request $request)
    {
        /** @var \App\User $user */
        $user = auth()->user();

        $user_arr = $user->toArray();
        $role = Role::where('id', $user_arr['role_id'])->with('permissions')->get(['id', 'role'])->toArray();
        $user_arr['role'] = $role[0];
        $success['user'] = $user_arr;
        $success['token'] = $user->createToken('api-user')->accessToken;

        $this->clearLoginAttempts($request);

        $success['token'] = $user->createToken(User::PASSPORT_ACCESS_TOKEN_NAME)->accessToken;

        return msg_success_login($success);
    }

    public function logout(Request $request)
    {
        $header = $request->bearerToken();
        $id = (new Parser())->parse($header)->getHeader('jti');
        $token = $request->user()->tokens->find($id);
        $token->revoke();

        return msg_success_logout();
    }
}
