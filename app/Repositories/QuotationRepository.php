<?php
/**
 * Created by PhpStorm.
 * User: damon
 * Date: 12/20/18
 * Time: 4:49 PM
 */

namespace App\Repositories;

use App\Mail\QuotationEmail;
use App\Quotation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Mail;

class QuotationRepository extends BaseRepository
{
    protected $accounting_service, $auditing, $annual, $consulting, $taxation, $customer;

    public function __construct()
    {
        $this->accounting_service = DataRepo::accounting_service();
        $this->auditing = DataRepo::auditing();
        $this->consulting = DataRepo::consulting();
        $this->taxation = DataRepo::taxation();
        $this->customer = DataRepo::customer();
    }

    public function model()
    {
        return Quotation::query();
    }

    public function validation(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'customer_id' => 'required',
            'business_id' => 'required',
            'sub_total' => 'required|int',
            'discount' => 'required|int',
            'tax' => 'required|int',
            'total' => 'required|int',
        ]);

        return $validator;
    }

    public function setData(Request $request)
    {
        $data = [
            'customer_id' => $request->input('customer_id'),
            'business_id' => $request->input('business_id'),
            'sub_total' => $request->input('sub_total'),
            'discount' => $request->input('discount'),
            'tax' => $request->input('tax'),
            'total' => $request->input('total'),
        ];

        return $data;
    }

    public function store(Request $request){

        $validator = $this->validation($request);
        if($validator->fails()){
            throw new ValidationException($validator);
        }

        $data = $this->setData($request);

        $quotation = $this->model()->create($data);

        if($request->input('accounting_check')){
            $this->accounting_service->store($request, $quotation->id);
        }
        if($request->input('auditing_check')){
            $this->auditing->store($request, $quotation->id);
        }
        if($request->input('consulting_check')){
            $this->consulting->store($request, $quotation->id);
        }
        if($request->input('taxation_check')){
            $this->taxation->store($request, $quotation->id);
        }

        $customer = $this->customer->find($quotation->customer_id)->toArray();

        $quotation = $this->with(['accounting_service', 'auditing', 'consulting', 'taxation'], $quotation->id)->toArray();

        Mail::to($customer['email'])->send(new QuotationEmail($quotation, $customer));

        return 'success';
    }

    public function update(Request $request, $id){

        $validator = $this->validation($request);
        if($validator->fails()){
            throw new ValidationException($validator);
        }

        $data = $this->setData($request);

        $this->model()->where('id', $id)->update($data);

        if($request->input('accounting_check')){
            $this->accounting_service->update($request, $id);
        }
        if($request->input('auditing_check')){
            $this->auditing->update($request, $id);
        }
        if($request->input('consulting_check')){
            $this->consulting->update($request, $id);
        }
        if($request->input('taxation_check')){
            $this->taxation->update($request, $id);
        }

        return 'success';
    }

}