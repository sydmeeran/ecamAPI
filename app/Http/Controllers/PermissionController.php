<?php

namespace App\Http\Controllers;

use App\Permission;
use Illuminate\Http\Request;

class PermissionController extends BaseController
{
    public function getAll(Request $request){
        if ($this->check_api_key($request)) {
            $permissions = Permission::where('id', '!=', 1)->get();
            return $this->response($permissions);
        }
        return response()->json($this->unauthorized);
    }

}
