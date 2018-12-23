<?php

namespace App\Http\Controllers;

use App\Repositories\DataRepo;
use Arga\Utils\ActionMiddlewareTrait;
use Illuminate\Http\Request;

class InvoiceController extends BaseController
{
    use ActionMiddlewareTrait;

    protected $invoice, $quotation;

    public function __construct(){

        $this->invoice = DataRepo::invoice();
        $this->quotation = DataRepo::quotation();

        $this->actionMiddleware([
            'store' => 'invoice-create',
            'pagination' => 'invoice-retrieve',
            'get' => 'invoice-retrieve',
            'update' => 'invoice-update',
            'delete' => 'invoice-delete',
        ]);
    }

    public function pagination(Request $request)
    {
        if ($this->check_api_key($request)) {
            $invoice = $this->quotation->model()->whereHas('invoice')->with('customer')->with('business')->with('invoice')->paginate(20);
            return $this->response($invoice);
        }
        return $this->unauthorized();
    }

    public function get(Request $request, $id){
        if ($this->check_api_key($request)) {
            $invoice = $this->invoice->with(['customer', 'business', 'accounting_service', 'auditing', 'consulting', 'taxation'], $id);
            if(empty($invoice)){
                return $this->empty_data();
            }
            $invoice = $invoice[0];
            return $this->response($invoice);
        }
        return $this->unauthorized();
    }

    public function store(Request $request){
        if ($this->check_api_key($request)) {
            return $this->invoice->store($request);
        }
        return $this->unauthorized();
    }



//    public function search(Request $request){
//        if ($this->check_api_key($request)) {
//
//            if($this->check_permission('job-entry-retrieve')){
//                $keyword = $request->get('keyword');
//                $result = $this->job_entry->model()->where( 'company_type', 'LIKE', '%' . $keyword . '%' )
//                    ->orWhere ( 'excel_type', 'LIKE', '%' . $keyword . '%' )
//                    ->orWhere ( 'excel_file', 'LIKE', '%' . $keyword . '%' )
//                    ->with('customer')->get()->toArray();
//
//                return $this->response($result);
//            }
//
//            return $this->permission_denied();
//        }
//        return $this->unauthorized();
//    }

    public function delete(Request $request, $id){
        if ($this->check_api_key($request)) {
            $this->invoice->delete($id);
            return $this->success();
        }

        return $this->unauthorized();
    }
}
