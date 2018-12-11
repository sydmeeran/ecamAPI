<?php

namespace App\Http\Controllers;

use App\Role;
use App\UUID;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BaseController extends Controller
{

    protected $success = [
        'status' => 'success'
    ];

    protected $unauthorized = [
        'status' => 'unauthorized'
    ];

    protected $unauthenticated = [
        'status' => 'unauthenticated'
    ];

    protected $permission_denied = [
        'status' => 'permission denied'
    ];

    protected function success(){
        return response()->json($this->success);
    }

    protected function unauthorized(){
        return response()->json($this->unauthorized);
    }

    protected function unauthenticated(){
        return response()->json($this->unauthenticated);
    }

    protected function permission_denied(){
        return response()->json($this->permission_denied);
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

    protected function check_permission($permission, $user_permissions = array()){
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


}
