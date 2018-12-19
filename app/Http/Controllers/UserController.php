<?php

namespace App\Http\Controllers;

use App\Repositories\DataRepo;
use App\Role;
use App\User;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\UnauthorizedException;
use Illuminate\Validation\ValidationException;

class UserController extends BaseController
{
    protected $user;

    public function __construct()
    {
        $this->user = DataRepo::user();
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     * @throws AuthenticationException
     */
    public function login()
    {
        if (Auth::attempt(['email' => request('email'), 'password' => request('password')])) {
            $user = Auth::user();
            $user_arr = $user->toArray();
            $role = Role::where('id', $user_arr['role_id'])->with('permissions')->get(['id', 'role'])->toArray();
            $user_arr['role'] = $role[0];
            $success['user'] = $user_arr;
            $success['token'] = $user->createToken('api-user')->accessToken;
            return $this->success_login_response($success);
        } else {
            return $this->unauthenticated();
        }
    }

    public function register(Request $request)
    {
        if ($this->check_api_key($request)) {
            if ($this->check_permission('user-create')) {

                return $this->user->store($request);

            }
            return $this->permission_denied();
        }
        return $this->unauthorized();
    }

    public function logout(Request $request)
    {
        if ($this->check_api_key($request)) {

            $request->user()->token()->delete();

            return $this->success();
        }
        return $this->unauthorized();
    }

    public function auth_user(Request $request)
    {
        if ($this->check_api_key($request)) {
            $user = Auth::user()->toArray();
            $role = Role::where('id', $user['role_id'])->with('permissions')->get(['id', 'role'])->toArray();
            $user['role'] = $role[0];
            return $this->response($user);
        }
        return $this->unauthorized();
    }

    public function getAll(Request $request)
    {
        if ($this->check_api_key($request)) {
            if($this->check_permission('user-retrieve')){
                $user = User::with('role')->get()->toArray();
                return $this->response($user);
            }
            return $this->permission_denied();
        }
        return $this->unauthorized();
    }

    public function getAll_pagination(Request $request)
    {
        if ($this->check_api_key($request)) {
            if($this->check_permission('user-retrieve')){
                $user = User::paginate(20);
                return $this->response($user);
            }
            return $this->permission_denied();
        }
        return $this->unauthorized();
    }

    public function get(Request $request, $id)
    {
        if ($this->check_api_key($request)) {

            if($this->check_permission('user-retrieve')){
                $user = User::where('id', $id)->get()->toArray();
                if(empty($user)){
                    return $this->empty_data();
                }
                $user = $user[0];
                $role = Role::where('id', $user['role_id'])->with('permissions')->get()->toArray();
                if(empty($role)){
                    return $this->empty_data();
                }
                $user['role'] = $role[0];
                return $this->response($user);
            }

            return $this->permission_denied();
        }
        return $this->unauthorized();
    }

    public function search(Request $request){
        if ($this->check_api_key($request)) {

            if($this->check_permission('user-retrieve')){
                $keyword = $request->get('keyword');
                $result = User::where ( 'name', 'LIKE', '%' . $keyword . '%' )
                    ->orWhere ( 'email', 'LIKE', '%' . $keyword . '%' )
                    ->get()->toArray();

                return $this->response($result);
            }

            return $this->permission_denied();
        }
        return $this->unauthorized();
    }

    public function delete(Request $request, $id){
        if ($this->check_api_key($request)) {

            if($this->check_permission('user-delete')){
                User::where('id', $id)->delete();
                return response()->json($this->success);
            }

            return $this->permission_denied();
        }
        return $this->unauthorized();
    }

    public function update_profile(Request $request, $id)
    {
        if ($this->check_api_key($request)) {
            if ($this->check_permission('user-update')) {

                return $this->user->update_profile($request, $id);

            }
            return $this->permission_denied();
        }
        return $this->unauthorized();
    }

    public function update_password(Request $request, $id){
        if ($this->check_api_key($request)) {
            if ($this->check_permission('user-update')) {

                return $this->user->update_password($request, $id);

            }
            return $this->permission_denied();
        }
        return $this->unauthorized();
    }

    public function active_deactive(Request $request, $id){
        if ($this->check_api_key($request)) {

            if($this->check_permission('user-update')){

                User::where('id', $id)->update([
                    'is_active' => $request->get('status')
                ]);
                return response()->json($this->success);

            }
            return $this->permission_denied();
        }
        return $this->unauthorized();
    }

}
