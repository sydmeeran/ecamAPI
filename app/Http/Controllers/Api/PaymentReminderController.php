<?php

namespace App\Http\Controllers\Api;

use App\Repositories\DataRepo;
use Arga\Utils\ActionMiddlewareTrait;
use Illuminate\Http\Request;

class PaymentReminderController extends BaseController
{
    use ActionMiddlewareTrait;

    protected $invoice, $quotation;

    public function __construct(){
        $this->actionMiddleware([
            'pagination' => 'invoice-retrieve',
            'paymentSuccess' => 'invoice-retrieve',
            'remarkStore' => 'invoice-retrieve'
        ]);

        $this->invoice = DataRepo::invoice();
    }

    public function pagination()
    {
            $invoice = $this->invoice->model()->where('is_active', 1)->whereDoesntHave('receipt')->with('member')->with('business')->paginate(20);
            return $this->response($invoice);
    }

    public function paymentSuccess()
    {
            $invoice = $this->invoice->model()->where('is_active', 1)->whereHas('receipt')->with('member')->with('business')->with('receipt')->paginate(20);
            return $this->response($invoice);
    }

    public function remarkStore(Request $request){
            $this->invoice->remarkStore($request);
            return $this->success();
    }
}
