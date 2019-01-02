<?php

namespace App\Http\Controllers\Api;

use App\Mail\QuotationEmail;
use App\Repositories\DataRepo;
use Arga\Utils\ActionMiddlewareTrait;
use Illuminate\Http\Request;
use Mail;

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
            $quotation = $this->quotation->model()
                ->with('customer')->with('business')->with('active_invoice')->paginate(20);
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
                    ->whereHas('customer', function($query) use ($keyword){
                        $query->where('owner_name', 'like', '%'.$keyword.'%')
                            ->orWhere('company_name', 'like', '%'.$keyword.'%');
                    })
                    ->orWhereHas('business', function($query) use ($keyword){
                        $query->where('business_name', 'like', '%'.$keyword.'%');
                    })
                    ->orWhere('quotation_id', 'like', '%'.$keyword.'%')
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
            $quotation = $this->quotation->with(['customer', 'business','accounting_service', 'auditing', 'consulting', 'taxation'], $id)->toArray();
            Mail::to($quotation[0]['customer']['email'])->send(new QuotationEmail($quotation));
            return 'success';
        }
        return $this->unauthorized();
    }

    public function cancel(Request $request, $id){
        if ($this->check_api_key($request)) {
            $this->quotation->model()->where('id', $id)->update(['is_active'=>0]);
            return $this->success();
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
