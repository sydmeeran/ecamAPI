<?php

namespace App\Http\Controllers;

use App\Permission;
use Illuminate\Http\Request;
//use Illuminate\Support\Facades\Validator;

class PermissionController extends BaseController
{
//    protected function store(Request $request)
//    {
//        if ($this->check_api_key($request)) {
//            $data = [
//                'permission' => $request->get('permission')
//            ];
//
//            $validator = Validator::make($data, [
//                'permission' => 'required|max:30|unique:permissions'
//            ]);
//
//            if ($validator->fails()) {
//                return $this->errors($validator);
//            }
//
//            Permission::create($data);
//
//            return response()->json($this->success);
//        }
//        return response()->json($this->unauthorized);
//    }

    public function getAll(Request $request){
        if ($this->check_api_key($request)) {
            $permissions = Permission::orderBy('permission')->get();
            return $this->response($permissions);
        }
        return response()->json($this->unauthorized);
    }

}
