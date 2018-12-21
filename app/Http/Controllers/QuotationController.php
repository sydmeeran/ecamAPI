<?php

namespace App\Http\Controllers;

use App\Repositories\DataRepo;
use Illuminate\Http\Request;

class QuotationController extends BaseController
{
    protected $repo;

    public function __construct(){

        $this->quotation = DataRepo::quotation();
    }

    public function store(Request $request){
        if ($this->check_api_key($request)) {
            if ($this->check_permission('quotation-create')) {
                return $this->quotation->store($request);
            }
            return $this->permission_denied();
        }
        return $this->unauthorized();
    }
}
