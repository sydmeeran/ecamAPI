<?php
/**
 * Created by PhpStorm.
 * User: damon
 * Date: 12/23/18
 * Time: 11:01 AM
 */

namespace App\Repositories;


use App\Mail\ReceiptEmail;
use App\Receipt;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Mail;

class ReceiptRepository extends BaseRepository
{
    protected $invoice, $member, $prefix;

    public function __construct()
    {
        $this->prefix = date('y');
        $this->invoice = DataRepo::invoice();
        $this->member = DataRepo::member();
    }

    public function pagination($collection, $total, $page, $perPage){
        
        return new \Illuminate\Pagination\LengthAwarePaginator($collection, $total, $perPage, $page, [
            'path' => \Illuminate\Pagination\Paginator::resolveCurrentPath(),
        ]);
    }

    public function model()
    {
        return Receipt::query();
    }

    public function validation(Request $request)
    {
        $rules = [
            'type' => 'required',
        ];

        if($request->input('type') == 'bank'){
            
            $rules['bank'] = 'required|string';
            $rules['bank_date'] = 'required|string';
        } else {
            $rules['cash_date'] = 'required|string';
            $rules['description'] = 'required|string';
        }

        if($request->invoice_id){
            $rules['invoice_id'] = 'required';
        } else {
            $rules['sponsor_donate_id'] = 'required';
        }

        return $request->validate($rules);
    }

    public function setData(Request $request)
    {
        $data = [
            'type' => $request->type,
        ];

        if($request->input('type') == 'bank'){
            
            $data['bank'] = $request->bank;
            $data['bank_date'] = new DateTime($request->bank_date);

        } else {
            $data['cash_date'] = new DateTime($request->cash_date);
            $data['description'] = $request->description;
        }

        if($request->invoice_id){
            $data['invoice_id'] = $request->invoice_id;
        } else {
            $data['sponsor_donate_id'] = $request->sponsor_donate_id;
        }

        return $data;
    }

    protected function generateReceiptId(){
        $receipt_id = $this->prefix.generateNumber(6);
        while($this->model()->where('receipt_id', $receipt_id)->exists()){
            $receipt_id = $this->prefix.generateNumber(6);
        }
        return $receipt_id;
    }

    public function store(Request $request){

        $this->validation($request);

        $data = $this->setData($request);
        $data['receipt_id'] = $this->generateReceiptId();

        $receipt = $this->model()->create($data);

        // $invoice = $this->invoice->with(['member', 'business', 'accounting_service', 'auditing', 'consulting', 'taxation', 'receipt'], $receipt->invoice_id)->toArray();

        // Mail::to($invoice[0]['member']['email'])->send(new ReceiptEmail($invoice));

        return 'success';
    }

}