<?php
/**
 * Created by PhpStorm.
 * User: damon
 * Date: 12/20/18
 * Time: 5:16 PM
 */

namespace App\Repositories\Quotation;


use App\Quotation;
use App\Taxation;
use App\Repositories\BaseRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class TaxationRepository extends BaseRepository
{

    public function model()
    {
        return Taxation::query();
    }

    public function validation($data){
        if($data['type'] == "m"){
            return Validator::make($data, [
                'type' => 'required',
                'value' => 'required',
                'months' => 'string',
                'years' => 'string|nullable',
                'quotation_id' => 'required',
            ]);
        }
        return Validator::make($data, [
            'type' => 'required',
            'value' => 'required',
            'months' => 'string|nullable',
            'years' => 'string',
            'quotation_id' => 'required',
        ]);
    }

    public function setData(Request $request, $quotation_id){
        return [
            'type' => $request->input('taxation_radio'),
            'months' => $request->input('taxation_months'),
            'years' => $request->input('taxation_years'),
            'quotation_id' => $quotation_id,
        ];
    }

    public function store(Request $request, $quotation_id){
        $data = $this->setData($request, $quotation_id);

        if($data['type'] == 'm' && !is_null($request->input('taxation_months'))){
            $data['value'] = $request->input('taxation_monthly_value');
            $data['months'] = implode(",", $request->input('taxation_months'));
        } elseif($data['type'] == 'y' && !is_null($request->input('taxation_years'))) {
            $data['value'] = $request->input('taxation_yearly_value');
            $data['years'] = implode(",", $request->input('taxation_years'));
        }

        $validator = $this->validation($data);
        if($validator->fails()){
            Quotation::destroy($quotation_id);
            throw new ValidationException($validator);
        }

        $this->model()->create($data);

        return 'success';
    }

    public function update(Request $request, $quotation_id){
        $data = $this->setData($request, $quotation_id);
        if($data['type'] == 'm' && !is_null($request->input('taxation_months'))){
            $data['value'] = $request->input('taxation_monthly_value');
            $data['months'] = implode(",", $request->input('taxation_months'));
        } elseif($data['type'] == 'y' && !is_null($request->input('taxation_years'))) {
            $data['value'] = $request->input('taxation_yearly_value');
            $data['years'] = implode(",", $request->input('taxation_years'));
        }

        $validator = $this->validation($data);
        if($validator->fails()){
            throw new ValidationException($validator);
        }

        $this->model()->where('quotation_id', $quotation_id)->delete();

        $this->model()->create($data);

        return 'success';
    }

    public function invoiceValidation($data){
        if($data['type'] == "m"){
            return Validator::make($data, [
                'type' => 'required',
                'value' => 'required',
                'months' => 'required|string',
                'years' => 'string|nullable',
                'invoice_id' => 'required',
            ]);
        }
        return Validator::make($data, [
            'type' => 'required',
            'value' => 'required',
            'months' => 'string|nullable',
            'years' => 'required|string',
            'invoice_id' => 'required',
        ]);
    }

    public function setInvoiceData(Request $request, $invoice_id){
        return [
            'type' => $request->input('taxation_radio'),
            'invoice_id' => $invoice_id,
        ];
    }

    public function storeByInvoice(Request $request, $invoice_id){
        $data = $this->setInvoiceData($request, $invoice_id);
        if($data['type'] == 'm' && !is_null($request->input('taxation_months'))){
            $data['value'] = $request->input('taxation_monthly_value');
            $data['months'] = implode(",", $request->input('taxation_months'));
        } elseif($data['type'] == 'y' && !is_null($request->input('taxation_years'))) {
            $data['value'] = $request->input('taxation_yearly_value');
            $data['years'] = implode(",", $request->input('taxation_years'));
        }

        $validator = $this->invoiceValidation($data);
        if($validator->fails()){
            throw new ValidationException($validator);
        }

        $this->model()->create($data);

        return 'success';
    }
}