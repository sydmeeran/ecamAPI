<?php

namespace App\Http\Controllers;

use App\Repositories\DataRepo;
use Arga\Utils\ActionMiddlewareTrait;
use Illuminate\Http\Request;

class ReceiptController extends BaseController
{
    use ActionMiddlewareTrait;

    protected $invoice, $receipt;

    public function __construct(){

        $this->invoice = DataRepo::invoice();
        $this->receipt = DataRepo::receipt();

        $this->actionMiddleware([
            'store' => 'receipt-create',
            'pagination' => 'receipt-retrieve',
            'get' => 'receipt-retrieve',
            'update' => 'receipt-update',
            'delete' => 'receipt-delete',
        ]);
    }

    public function pagination(Request $request)
    {
        if ($this->check_api_key($request)) {
            $receipt = $this->invoice->model()->whereHas('receipt')->with('receipt')->with('customer')->with('business')->paginate(20);
            return $this->response($receipt);
        }
        return $this->unauthorized();
    }

    public function get(Request $request, $id){
        if ($this->check_api_key($request)) {
            $receipt = $this->receipt->model()->where('id', $id)->get()->toArray();
            if(empty($receipt)){
                return $this->empty_data();
            }
            $receipt = $this->invoice->with(['receipt', 'customer', 'business', 'accounting_service', 'auditing', 'consulting', 'taxation'], $receipt[0]['invoice_id'])->toArray();
//            $invoice = $this->invoice->with(['customer', 'business', 'accounting_service', 'auditing', 'consulting', 'taxation'], $receipt->invoice_id);
            if(empty($receipt)){
                return $this->empty_data();
            }
            $receipt = $receipt[0];
            return $this->response($receipt);
        }
        return $this->unauthorized();
    }

    public function store(Request $request){
        if ($this->check_api_key($request)) {
            return $this->receipt->store($request);
        }
        return $this->unauthorized();
    }



    public function search(Request $request){
        if ($this->check_api_key($request)) {

            if($this->check_permission('receipt-retrieve')){
                $keyword = $request->get('keyword');
                $result = $this->invoice->model()->whereHas('receipt')
                    ->with(['customer' => function($query) use ($keyword){
                        $query->where('owner_name', 'like', '%'.$keyword.'%')
                            ->orWhere('company_name', 'like', '%'.$keyword.'%');
                    }])
                    ->with(['business' => function($query) use ($keyword){
                        $query->where('business_name', 'like', '%'.$keyword.'%');
                    }])
                    ->with('business')->with('customer')->with('receipt')
                    ->get();

                return $this->response($result);
            }

            return $this->permission_denied();
        }
        return $this->unauthorized();
    }


    public function delete(Request $request, $id){
        if ($this->check_api_key($request)) {
            $this->receipt->delete($id);
            return $this->success();
        }

        return $this->unauthorized();
    }
}
