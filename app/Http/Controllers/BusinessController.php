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
}
