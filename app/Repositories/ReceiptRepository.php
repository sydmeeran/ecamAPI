<?php
/**
 * Created by PhpStorm.
 * User: damon
 * Date: 12/23/18
 * Time: 11:01 AM
 */

namespace App\Repositories;


use App\Receipt;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class ReceiptRepository extends BaseRepository
{
    protected $invoice;

    public function __construct()
    {
        $this->invoice = DataRepo::invoice();
    }

    public function model()
    {
        return Receipt::query();
    }

    public function validation(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'invoice_id' => 'required',
            'type' => 'required',
            'bank' => 'string|nullable',
            'bank_date' => 'string|nullable',
            'cash_date' => 'string|nullable',
            'description' => 'string|nullable',
        ]);

        return $validator;
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

    public function store(Request $request){

        $validator = $this->validation($request);
        if($validator->fails()){
            throw new ValidationException($validator);
        }

        $data = $this->setData($request);

        $this->model()->create($data);

        return 'success';
    }

}