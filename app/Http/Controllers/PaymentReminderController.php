<?php
//
//namespace App\Http\Controllers;
//
//use App\Repositories\DataRepo;
//use Arga\Utils\ActionMiddlewareTrait;
//use Illuminate\Http\Request;
//
//class PaymentReminderController extends BaseController
//{
//    use ActionMiddlewareTrait;
//
//    protected $invoice, $quotation;
//
//    public function __construct(){
//
//        $this->invoice = DataRepo::invoice();
//
//        $this->actionMiddleware([
//            'store' => 'invoice-create',
//            'pagination' => 'invoice-retrieve',
//            'get' => 'invoice-retrieve',
//            'update' => 'invoice-update',
//            'delete' => 'invoice-delete',
//            'remark-store' => 'invoice-retrieve'
//        ]);
//    }
//
//    public function pagination(Request $request)
//    {
//        if ($this->check_api_key($request)) {
//            $invoice = $this->invoice->model()->where('is_active', 1)->whereDoesntHave('receipt')->with('customer')->with('business')->paginate(20);
//            return $this->response($invoice);
//        }
//        return $this->unauthorized();
//    }
//
//    public function paymentSuccess(Request $request)
//    {
//        if ($this->check_api_key($request)) {
//            $invoice = $this->invoice->model()->where('is_active', 1)->whereHas('receipt')->with('customer')->with('business')->with('receipt')->paginate(20);
//            return $this->response($invoice);
//        }
//        return $this->unauthorized();
//    }
//
//    public function remarkStore(Request $request){
//        if ($this->check_api_key($request)) {
//            $this->invoice->remarkStore($request);
//            return $this->success();
//        }
//
//        return $this->unauthorized();
//    }
//
//}
