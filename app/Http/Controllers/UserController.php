<?php

namespace App\Http\Controllers;

use App\Repositories\DataRepo;
use App\Role;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UserController extends BaseController
{
    protected $user;

    public function __construct()
    {
        $this->user = DataRepo::user();
    }

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

                $status = $this->user->store($request);

                if($status === 'success'){
                    return $this->success();
                }

                return $this->errors($status);

            }
            return $this->permission_denied();
        }
        return $this->unauthorized();
    }

    public function logout(Request $request)
    {
        if ($this->check_api_key($request)) {

            $request->user()->token()->delete();

            return response()->json($this->success);
        }
        return response()->json($this->unauthorized);
    }

    public function auth_user(Request $request)
    {
        if ($this->check_api_key($request)) {
            $user = Auth::user()->toArray();
            $role = Role::where('id', $user['role_id'])->with('permissions')->get(['id', 'role'])->toArray();
            $user['role'] = $role[0];
            return $this->response($user);
        }
        return response()->json($this->unauthorized);
    }

    public function getAll(Request $request)
    {
        if ($this->check_api_key($request)) {
            if($this->check_permission('user-retrieve')){
                $user = User::with('role')->get()->toArray();
                return $this->response($user);
            }
            return response()->json($this->permission_denied);
        }
        return response()->json($this->unauthorized);
    }

    public function getAll_pagination(Request $request)
    {
        if ($this->check_api_key($request)) {
            if($this->check_permission('user-retrieve')){
                $user = User::paginate(20);
                return $this->response($user);
            }
            return response()->json($this->permission_denied);
        }
        return response()->json($this->unauthorized);
    }

    public function get(Request $request, $id)
    {
        if ($this->check_api_key($request)) {

            if($this->check_permission('user-retrieve')){
                $user = User::where('id', $id)->get()->toArray();
                if(empty($user)){
                    return $this->response($user);
                }
                $user = $user[0];
                $role = Role::where('id', $user['role_id'])->with('permissions')->get()->toArray();
                if(empty($role)){
                    return $this->response($role);
                }
                $user['role'] = $role[0];
                return $this->response($user);
            }

            return response()->json($this->permission_denied);
        }
        return response()->json($this->unauthorized);
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

            return response()->json($this->permission_denied);
        }
        return response()->json($this->unauthorized);
    }

    public function delete(Request $request, $id){
        if ($this->check_api_key($request)) {

            if($this->check_permission('user-delete')){
                User::where('id', $id)->delete();
                return response()->json($this->success);
            }

            return response()->json($this->permission_denied);
        }
        return response()->json($this->unauthorized);
    }

    public function update(Request $request, $id)
    {
        if ($this->check_api_key($request)) {
            if ($this->check_permission('user-update')) {

                $data = [
                    'name' => $request->get('name'),
                    'email' => $request->get('email'),
                    'position' => $request->get('position'),
                    'nrc_no' => $request->get('nrc_no'),
                    'phone_no' => $request->get('phone_no'),
                    'address' => $request->get('address'),
                    'role_id' => $request->get('role_id')
                ];

                $user = User::where('id', $id)->get()->toArray();

                if($data['email'] == $user[0]['email']){
                    $validator = Validator::make($request->all(), [
                        'name' => 'required',
                        'position' => 'required|string',
                        'nrc_no' => 'required|string',
                        'phone_no' => 'required|string',
                        'address' => 'required|string',
                        'role_id' => 'required|int',
                        'profile_photo.*' => 'image|mimes:jpeg,png,jpg|max:2048',
                    ]);

                } else {
                    $validator = Validator::make($request->all(), [
                        'name' => 'required',
                        'email' => 'required|unique:users',
                        'position' => 'required|string',
                        'nrc_no' => 'required|string',
                        'phone_no' => 'required|string',
                        'address' => 'required|string',
                        'role_id' => 'required|int',
                        'profile_photo.*' => 'image|mimes:jpeg,png,jpg|max:2048',
                    ]);
                }

                if ($validator->fails()) {
                    return $this->errors($validator);
                }

                if (Input::hasFile('profile_photo')) {
                    $user = $this->find($id);
                    if(file_exists($user->profile_photo)){
                        unlink($user->profile_photo);
                    }
                    $profile_photo_name = $this->storeNrcPhoto($request);
                    $data['profile_photo'] = $profile_photo_name;
                }

                User::where('id', $id)->update($data);

                return response()->json($this->success);
            }
            return response()->json($this->permission_denied);
        }
        return response()->json($this->unauthorized);
    }

    public function active_deactive(Request $request, $id){
        if ($this->check_api_key($request)) {

            if($this->check_permission('user-update')){

                User::where('id', $id)->update([
                    'is_active' => $request->get('status')
                ]);
                return response()->json($this->success);

            }
            return response()->json($this->permission_denied);
        }
        return response()->json($this->unauthorized);
    }

}
