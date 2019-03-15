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

    public function model()
    {
        return Receipt::query();
    }

    public function validation(Request $request)
    {
        if($request->input('type') == 'bank'){
            return Validator::make($request->all(), [
                'invoice_id' => 'required',
                'type' => 'required',
                'bank' => 'required|string',
                'bank_date' => 'required|string',
            ]);
        }
        return Validator::make($request->all(), [
            'invoice_id' => 'required',
            'type' => 'required',
            'cash_date' => 'required|string',
            'description' => 'required|string',
        ]);
    }

    public function setData(Request $request)
    {
        $data = [
            'invoice_id' => $request->input('invoice_id'),
            'type' => $request->input('type'),
            'bank' => $request->input('bank'),
            'bank_date' => new DateTime($request->input('bank_date')),
            'cash_date' => new DateTime($request->input('cash_date')),
            'description' => $request->input('description'),
        ];

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

        $validator = $this->validation($request);
        if($validator->fails()){
            throw new ValidationException($validator);
        }

        $data = $this->setData($request);
        $data['receipt_id'] = $this->generateReceiptId();

        $receipt = $this->model()->create($data);

        $invoice = $this->invoice->with(['member', 'business', 'accounting_service', 'auditing', 'consulting', 'taxation', 'receipt'], $receipt->invoice_id)->toArray();

        Mail::to($invoice[0]['member']['email'])->send(new ReceiptEmail($invoice));

        return 'success';
    }

}