<?php
/**
 * Created by PhpStorm.
 * User: damon
 * Date: 12/23/18
 * Time: 11:01 AM
 */

namespace App\Repositories;


use App\Invoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class InvoiceRepository extends BaseRepository
{
    protected $quotation, $accounting_service, $auditing, $annual, $consulting, $taxation;

    public function __construct()
    {
        $this->quotation = DataRepo::quotation();
        $this->accounting_service = DataRepo::accounting_service();
        $this->auditing = DataRepo::auditing();
        $this->consulting = DataRepo::consulting();
        $this->taxation = DataRepo::taxation();
    }

    public function model()
    {
        return Invoice::query();
    }

    public function validation(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'quotation_id' => 'required',
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
            'quotation_id' => $request->input('quotation_id'),
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
        $update_data = array_except($data, 'quotation_id');

        $this->quotation->model()->where('id', $data['quotation_id'])->update($update_data);

        $this->model()->create([
           'quotation_id' => $data['quotation_id']
        ]);

        if($request->input('accounting_check')){
            $this->accounting_service->update($request, $data['quotation_id']);
        }
        if($request->input('auditing_check')){
            $this->auditing->update($request, $data['quotation_id']);
        }
        if($request->input('consulting_check')){
            $this->consulting->update($request, $data['quotation_id']);
        }
        if($request->input('taxation_check')){
            $this->taxation->update($request, $data['quotation_id']);
        }

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