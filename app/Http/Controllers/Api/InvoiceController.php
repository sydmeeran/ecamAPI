<?php

namespace App\Http\Controllers\Api;

use App\Mail\InvoiceEmail;
use App\Repositories\DataRepo;
use Arga\Utils\ActionMiddlewareTrait;
use Illuminate\Http\Request;
use Mail;

class InvoiceController extends BaseController
{
    use ActionMiddlewareTrait;

    protected $invoice, $quotation;

    public function __construct(Request $request)
    {
        $this->check_api_key($request);

        $this->actionMiddleware([
            'store' => 'invoice-create',
            'pagination' => 'invoice-retrieve',
            'search' => 'invoice-retrieve',
            'get' => 'invoice-retrieve',
            'cancel' => 'invoice-delete',
        ]);

        $this->invoice = DataRepo::invoice();
        $this->quotation = DataRepo::quotation();
    }

    public function pagination()
    {
        $invoice = $this->invoice->model()->with('customer')->with('business')->with('receipt')->paginate(20);
        return $this->response($invoice);
    }

    public function get($id)
    {
        $invoice = $this->invoice->with(['customer', 'business', 'receipt', 'accounting_service', 'auditing', 'consulting', 'taxation', 'remarks'], $id)->toArray();
        if (empty($invoice)) {
            return $this->empty_data();
        }
        $invoice = $invoice[0];
        return $this->response($invoice);
    }

    public function store(Request $request)
    {
        return $this->invoice->store($request);
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
            ->orWhere('invoice_id', 'like', '%' . $keyword . '%')
            ->with(['business', 'customer'])
            ->get();

        return $this->response($result);
    }

    public function send_mail($id)
    {
        $invoice = $this->invoice->with(['customer', 'business', 'accounting_service', 'auditing', 'consulting', 'taxation'], $id)->toArray();
        Mail::to($invoice[0]['customer']['email'])->send(new InvoiceEmail($invoice));
        return 'success';
    }

    public function cancel($id)
    {
        $this->invoice->model()->where('id', $id)->update(['is_active' => 0]);
        return $this->success();
    }
}
