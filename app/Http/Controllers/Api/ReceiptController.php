<?php

namespace App\Http\Controllers\Api;

use App\Mail\ReceiptEmail;
use App\Repositories\DataRepo;
use Arga\Utils\ActionMiddlewareTrait;
use Illuminate\Http\Request;
use Mail;
use App\Http\Resources\ReceiptCollection;

class ReceiptController extends BaseController
{
    use ActionMiddlewareTrait;

    protected $invoice, $receipt;

    public function __construct()
    {
        $this->actionMiddleware([
            'store' => 'receipt-create',
            'pagination' => 'receipt-retrieve',
            'get' => 'receipt-retrieve',
            'search' => 'receipt-retrieve',
        ]);

        $this->invoice = DataRepo::invoice();
        $this->receipt = DataRepo::receipt();
    }

    public function resource(){
        ReceiptCollection::withoutWrapping();
        return ReceiptCollection::class;
    }

    // public function collection($query){
    //     return $this->resource()::collection($query);
    // }

    public function pagination(Request $request)
    {
        $all = $this->receipt->model()->get();
        // dd($all);
        $collection = collect($this->resource()::collection($all));
        $page = $request->page;
        $perPage = 20;
        $total = $collection->count();
        // dd($total);
        // $data = $this->receipt->where('') 

        $receipt = $this->receipt->pagination($collection, $total, $page, $perPage);
        return $this->response($receipt);
    }

    public function get($id)
    {
        $receipt = $this->receipt->find($id)->toArray();
        if (empty($receipt)) {
            return $this->empty_data();
        }
        
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
            ->whereHas('member', function ($query) use ($keyword) {
                $query->where('owner_name', 'like', '%' . $keyword . '%')
                    ->orWhere('company_name', 'like', '%' . $keyword . '%');
            })
            ->orWhereHas('business', function ($query) use ($keyword) {
                $query->where('business_name', 'like', '%' . $keyword . '%');
            })
            ->orWhereHas('receipt', function ($query) use ($keyword) {
                $query->where('receipt_id', 'like', '%' . $keyword . '%');
            })
            ->with(['business', 'member', 'receipt'])
            ->get();

        return $this->response($result);
    }

    public function send_mail($id)
    {
        $receipt = $this->receipt->find($id);
        $invoice = $this->invoice->with(['member', 'business', 'accounting_service', 'auditing', 'consulting', 'taxation', 'receipt'], $receipt->invoice_id)->toArray();
        Mail::to($invoice[0]['member']['email'])->send(new ReceiptEmail($invoice));
        return 'success';
    }

    public function delete($id)
    {
        $this->receipt->model()->where('id', $id)->delete();
        return $this->success();
    }
}
