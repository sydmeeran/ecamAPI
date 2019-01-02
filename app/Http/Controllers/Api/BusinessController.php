<?php

namespace App\Http\Controllers\Api;

use App\Repositories\DataRepo;
use Arga\Utils\ActionMiddlewareTrait;
use Illuminate\Http\Request;

class BusinessController extends BaseController
{
    use ActionMiddlewareTrait;

    protected $business;

    public function __construct()
    {
        $this->business = DataRepo::business();
        $this->actionMiddleware([
            'store' => 'customer-update',
            'update' => 'customer-update',
            'delete' => 'customer-update',
            'get' => 'customer-retrieve',
            'getByCustomer' => 'customer-retrieve',
        ]);
    }

    public function store(Request $request, $customer_id)
    {
        if ($this->check_api_key($request)) {
            return $this->business->register($request, $customer_id);
        }
        return $this->unauthorized();
    }

    public function update(Request $request, $id)
    {
        if ($this->check_api_key($request)) {

            return $this->business->update($request, $id);
        }
        return $this->unauthorized();
    }

    public function delete(Request $request, $id)
    {
        if ($this->check_api_key($request)) {

            $this->business->delete($id);

            return $this->success();
        }
        return $this->unauthorized();
    }

    public function get(Request $request, $id)
    {
        if ($this->check_api_key($request)) {
            $business = $this->business->find($id)->toArray();

            if (empty($business)) {
                return $this->empty_data();
            }
            return $this->response($business);
        }
        return $this->unauthorized();
    }

    public function getAll(Request $request)
    {
        if ($this->check_api_key($request)) {
            $business = $this->business->getAll();
            return $this->response($business);

        }
        return $this->unauthorized();
    }

//    public function getByCustomer(Request $request, $customer_id)
//    {
//        if ($this->check_api_key($request)) {
//            $business = $this->business->model()->where('customer_id', $customer_id)->get()->toArray();
//
//            if(empty($business)){
//                return $this->response($business);
//            }
//            return $this->response($business);
//        }
//        return $this->unauthorized();
//    }
}
