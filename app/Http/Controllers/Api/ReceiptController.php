<?php

namespace App\Http\Controllers\Api;

use App\Mail\ReceiptEmail;
use App\Repositories\DataRepo;
use Arga\Utils\ActionMiddlewareTrait;
use Illuminate\Http\Request;
use Mail;

class ReceiptController extends BaseController
{
    use ActionMiddlewareTrait;

    protected $invoice, $receipt;

    public function __construct(Request $request)
    {
        $this->check_api_key($request);

        $this->actionMiddleware([
            'store' => 'receipt-create',
            'pagination' => 'receipt-retrieve',
            'get' => 'receipt-retrieve',
            'search' => 'receipt-retrieve',
        ]);

        $this->invoice = DataRepo::invoice();
        $this->receipt = DataRepo::receipt();
    }

    public function pagination()
    {
        $receipt = $this->invoice->model()->whereHas('receipt')->with('receipt')->with('customer')->with('business')->paginate(20);
        return $this->response($receipt);
    }

    public function get($id)
    {
        $receipt = $this->receipt->model()->where('id', $id)->get()->toArray();
        if (empty($receipt)) {
            return $this->empty_data();
        }
        $receipt = $this->invoice->with(['receipt', 'customer', 'business', 'accounting_service', 'auditing', 'consulting', 'taxation'], $receipt[0]['invoice_id'])->toArray();

        if (empty($receipt)) {
            return $this->empty_data();
        }

        $receipt = $receipt[0];
        return $this->response($receipt);
    }

    public function store(Request $request)
    {
        return $this->receipt->store($request);
    }

    public function search(Request $request)
    {
        $keyword = $request->get('keyword');
        $result = $this->invoice->model()
            ->whereHas('customer', function ($query) use ($keyword) {
                $query->where('owner_name', 'like', '%' . $keyword . '%')
                    ->orWhere('company_name', 'like', '%' . $keyword . '%');
            })
            ->orWhereHas('business', function ($query) use ($keyword) {
                $query->where('business_name', 'like', '%' . $keyword . '%');
            })
            ->orWhereHas('receipt', function ($query) use ($keyword) {
                $query->where('receipt_id', 'like', '%' . $keyword . '%');
            })
            ->with(['business', 'customer', 'receipt'])
            ->get();

        return $this->response($result);
    }

    public function send_mail($id)
    {
        $receipt = $this->receipt->find($id);
        $invoice = $this->invoice->with(['customer', 'business', 'accounting_service', 'auditing', 'consulting', 'taxation', 'receipt'], $receipt->invoice_id)->toArray();
        Mail::to($invoice[0]['customer']['email'])->send(new ReceiptEmail($invoice));
        return 'success';
    }
}
