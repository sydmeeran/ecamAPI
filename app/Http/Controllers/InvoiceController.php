<?php

namespace App\Http\Controllers;

use App\Mail\InvoiceEmail;
use App\Receipt;
use App\Repositories\DataRepo;
use Arga\Utils\ActionMiddlewareTrait;
use Illuminate\Http\Request;
use Mail;

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
            $invoice = $this->invoice->model()->with('customer')->with('business')->with('receipt')->paginate(20);
            return $this->response($invoice);
        }
        return $this->unauthorized();
    }

    public function get(Request $request, $id){
        if ($this->check_api_key($request)) {
            $invoice = $this->invoice->with(['customer', 'business', 'receipt', 'accounting_service', 'auditing', 'consulting', 'taxation', 'remarks'], $id)->toArray();
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

    public function search(Request $request){
        if ($this->check_api_key($request)) {

            if($this->check_permission('invoice-retrieve')){
                $keyword = $request->get('keyword');
                $result = $this->invoice->model()
                    ->whereHas('customer', function($query) use ($keyword){
                        $query->where('owner_name', 'like', '%'.$keyword.'%')
                            ->orWhere('company_name', 'like', '%'.$keyword.'%');
                    })
                    ->orWhereHas('business', function($query) use ($keyword){
                        $query->where('business_name', 'like', '%'.$keyword.'%');
                    })
                    ->orWhere('invoice_id', 'like', '%'.$keyword.'%')
                    ->with(['business', 'customer'])
                    ->get();

                return $this->response($result);
            }


            return $this->permission_denied();
        }
        return $this->unauthorized();
    }

    public function send_mail(Request $request, $id)
    {
        if ($this->check_api_key($request)) {
            $invoice = $this->invoice->with(['customer', 'business', 'accounting_service', 'auditing', 'consulting', 'taxation'], $id)->toArray();
            Mail::to($invoice[0]['customer']['email'])->send(new InvoiceEmail($invoice));
            return 'success';
        }
        return $this->unauthorized();
    }

    public function cancel(Request $request, $id){
        if ($this->check_api_key($request)) {
            $this->invoice->model()->where('id', $id)->update(['is_active'=>0]);
            return $this->success();
        }

        return $this->unauthorized();
    }

    public function delete(Request $request, $id){
        if ($this->check_api_key($request)) {
            $this->invoice->delete($id);
            return $this->success();
        }

        return $this->unauthorized();
    }
}
