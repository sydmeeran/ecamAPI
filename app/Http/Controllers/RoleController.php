<?php

namespace App\Http\Controllers;

use App\Role;
use App\RolePermission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RoleController extends BaseController
{

    public function store(Request $request){

        if($this->check_api_key($request)) {
            if($this->check_permission('role-create')){
                $data = [
                    'role' => $request->get('role'),
                    'permissions' => $request->get('permissions')
                ];

                $validator = Validator::make($data, [
                    'role' => 'required|max:30|unique:roles',
                    'permissions' => 'required'
                ]);

                if ($validator->fails()) {
                    return $this->errors($validator);
                }

                $role = Role::create([
                    'role' => $data['role']
                ]);

                foreach($data['permissions'] as $permission_id){
                    RolePermission::create([
                        'role_id' => $role->id,
                        'permission_id' => $permission_id
                    ]);
                }

                return response()->json($this->success);
            }
            return response()->json($this->permission_denied);
        }

        return response()->json($this->unauthorized);
    }

    public function update(Request $request, $id)
    {
        if ($this->check_api_key($request)) {
            if ($this->check_permission('role-update')) {

                $data = [
                    'role' => $request->get('role'),
                    'permissions' => $request->get('permissions')
                ];

                $validator = Validator::make($data, [
                    'role' => 'required|max:30|unique:roles',
                    'permissions' => 'required'
                ]);

                if ($validator->fails()) {
                    return $this->errors($validator);
                }

                Role::where('id', $id)->update([
                    'role' => $data['role']
                ]);

                RolePermission::where('role_id', $id)->delete();

                foreach($data['permissions'] as $permission_id){
                    RolePermission::create([
                        'role_id' => $id,
                        'permission_id' => $permission_id
                    ]);
                }

                return response()->json($this->success);
            }
            return response()->json($this->permission_denied);
        }
        return response()->json($this->unauthorized);
    }

    public function getAll(Request $request){

        if($this->check_api_key($request)) {
            if($this->check_permission('role-retrieve')) {
                $roles = Role::with('permissions')->get()->toArray();
                return $this->response($roles);
            }
            return response()->json($this->unauthorized);
        }

        return response()->json($this->unauthorized);
    }

    public function get(Request $request, $id){
        if($this->check_api_key($request)) {
            if($this->check_permission('role-retrieve')){
                $role = Role::where('id', $id)->with('permissions')->get()->toArray();
                if(empty($role)){
                    return $this->response($role);
                }
                return $this->response($role[0]);
            }
            return response()->json($this->permission_denied);
        }

        return response()->json($this->unauthorized);
    }

    public function delete(Request $request, $id){
        if ($this->check_api_key($request)) {

            if($this->check_permission('role-delete')){
                Role::where('id', $id)->delete();
                return response()->json($this->success);
            }

            return response()->json($this->unauthorized);
        }
        return response()->json($this->unauthorized);
    }
}
