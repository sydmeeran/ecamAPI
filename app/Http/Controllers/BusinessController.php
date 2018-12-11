<?php

namespace App\Http\Controllers;

use App\Repositories\DataRepo;
use Illuminate\Http\Request;

class BusinessController extends BaseController
{
    protected $business;

    public function __construct(){
        $this->business = DataRepo::business();
    }

    public function update(Request $request, $id){
        if ($this->check_api_key($request)) {
            if ($this->check_permission('customer-update')) {

                $status = $this->business->update($request, $id);

                if ($status === 'success') {
                    return $this->success();
                }

                return $this->errors($status);
            }
            return $this->permission_denied();
        }
        return $this->unauthorized();
    }

    public function delete(Request $request, $id){
        if ($this->check_api_key($request)) {
            if ($this->check_permission('customer-update')) {

                $this->business->delete($id);

                return $this->success();
            }
            return $this->permission_denied();
        }
        return $this->unauthorized();
    }

    public function get(Request $request, $id)
    {
        if ($this->check_api_key($request)) {

            if($this->check_permission('customer-retrieve')){
                $business = $this->business->find($id)->toArray();

                if(empty($business)){
                    return $this->response($business);
                }
                return $this->response($business);
            }

            return $this->permission_denied();
        }
        return $this->unauthorized();
    }
}
