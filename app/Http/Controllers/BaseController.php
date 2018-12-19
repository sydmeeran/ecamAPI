<?php

namespace App\Http\Controllers;

use App\Role;
use App\UUID;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BaseController extends Controller
{

    protected $success = [
        'message' => 'success'
    ];

    protected $unauthorized = [
        'message' => 'unauthorized'
    ];

    protected $unauthenticated = [
        'message' => 'unauthenticated'
    ];

    protected $permission_denied = [
        'message' => 'permission denied'
    ];

    protected $empty_data = [
        'message' => 'Data Not Available'
    ];

    protected $role_exists = [
        'message' => 'User Has Registered With This Role'
    ];


    protected function success(){
        return response()->json($this->success);
    }

    protected function unauthorized(){
        throw new UnauthorizedException();
    }

    protected function unauthenticated(){
        throw new AuthenticationException();
    }

    protected function permission_denied(){
        return response()->json($this->permission_denied, 403);
    }

    protected function empty_data(){
        return response()->json($this->empty_data, 401);
    }

    protected function role_exists(){
        return response()->json($this->role_exists, 401);
    }

    protected function errors($validator){
        return response()->json([
            'errors' => $validator->errors(),
            'status' => 'error'
        ]);
    }

    protected function check_api_key(Request $request){
        if($request->header('api-key') == env('API_KEY')){
            return true;
        }
        return false;
    }

    protected function success_login_response($success){
        return response()->json([
            'user' => $success['user'],
            'token' => $success['token'],
            'status' => 'success'
        ]);
    }

    protected function response($data){
        if(empty($data)){
            $data = 'empty';
        }
        return response()->json([
            'data' => $data,
            'status' => 'success'
        ]);
    }

    protected function check_permission($permission){
        $role_id = Auth::user()->role_id;
        $role = Role::where('id', $role_id)->with('permissions')->get()->toArray();
        foreach($role[0]['permissions'] as $role_permission){
            $user_permissions[] = $role_permission['permission'];
        }
        if(in_array('all', $user_permissions) || in_array($permission, $user_permissions)){
            return true;
        }
        return false;
    }

    public function check_api_auth(Request $request, $permission = 'all'){
        if ($this->check_api_key($request)) {
            if ($this->check_permission($permission)) {
                return true;
            }
            return $this->permission_denied();
        }
        return $this->unauthorized();
    }


}
