<?php

namespace App\Http\Controllers;

use App\Repositories\DataRepo;
use Arga\Utils\ActionMiddlewareTrait;
use Illuminate\Http\Request;

class QuotationController extends BaseController
{
    use ActionMiddlewareTrait;

    protected $quotation;

    public function __construct(){

        $this->quotation = DataRepo::quotation();

        $this->actionMiddleware([
           'store' => 'quotation-create',
           'pagination' => 'quotation-retrieve',
           'get' => 'quotation-retrieve',
           'update' => 'quotation-update',
           'delete' => 'quotation-delete',
        ]);
    }

    public function pagination(Request $request)
    {
        if ($this->check_api_key($request)) {
            $quotation = $this->quotation->model()->with('customer')->with('business')->with('invoice')->paginate(20);
            return $this->response($quotation);
        }
        return $this->unauthorized();
    }

    public function get(Request $request, $id){
        if ($this->check_api_key($request)) {
            $quotation = $this->quotation->with(['customer', 'business', 'accounting_service', 'auditing', 'consulting', 'taxation', 'invoice'], $id)->toArray();
            if(empty($quotation)){
                return $this->empty_data();
            }
            $quotation = $quotation[0];
            return $this->response($quotation);
        }
        return $this->unauthorized();
    }

    public function store(Request $request){
        if ($this->check_api_key($request)) {
            return $this->quotation->store($request);
        }
        return $this->unauthorized();
    }

    public function update(Request $request, $id)
    {
        if ($this->check_api_key($request)) {
            return $this->quotation->update($request, $id);
        }
        return $this->unauthorized();
    }

    public function search(Request $request){
        if ($this->check_api_key($request)) {

            if($this->check_permission('quotation-retrieve')){
                $keyword = $request->get('keyword');
                $result = $this->quotation->model()
                    ->with(['customer' => function($query) use ($keyword){
                        $query->where('owner_name', 'like', '%'.$keyword.'%')
                            ->orWhere('company_name', 'like', '%'.$keyword.'%');
                    }])
                    ->with(['business' => function($query) use ($keyword){
                        $query->where('business_name', 'like', '%'.$keyword.'%');
                    }])
                    ->with('business')->with('customer')
                    ->get();

                return $this->response($result);
            }

            return $this->permission_denied();
        }
        return $this->unauthorized();
    }

    public function delete(Request $request, $id){
        if ($this->check_api_key($request)) {
                $this->quotation->delete($id);
                return $this->success();
            }

        return $this->unauthorized();
    }


}
