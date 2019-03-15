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
        $this->actionMiddleware([
            'store' => 'member-update',
            'update' => 'member-update',
            'delete' => 'member-update',
            'get' => 'member-retrieve',
//            'getByCustomer' => 'member-retrieve',
        ]);

        $this->business = DataRepo::business();
    }

    public function store(Request $request, $member_id)
    {
        return $this->business->register($request, $member_id);
    }

    public function update(Request $request, $id)
    {
        return $this->business->update($request, $id);
    }

    public function delete($id)
    {
        $this->business->delete($id);

        return $this->success();
    }

    public function get($id)
    {
        $business = $this->business->find($id)->toArray();

        if (empty($business)) {
            return $this->empty_data();
        }
        return $this->response($business);
    }

    public function getAll()
    {
        $business = $this->business->getAll();
        return $this->response($business);
    }


}
