<?php
/**
 * Created by PhpStorm.
 * User: damon
 * Date: 12/20/18
 * Time: 5:16 PM
 */

namespace App\Repositories\Quotation;


use App\AccountingService;
use App\Quotation;
use App\Repositories\BaseRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class AccountingServiceRepository extends BaseRepository
{

    public function model()
    {
        return AccountingService::query();
    }

    public function validation($data){
        if($data['type'] == "m"){
            return Validator::make($data, [
                'type' => 'required',
                'value' => 'required',
                'months' => 'required|string',
                'years' => 'string|nullable',
                'quotation_id' => 'required',
            ]);
        }
        return Validator::make($data, [
            'type' => 'required',
            'value' => 'required',
            'months' => 'string|nullable',
            'years' => 'required|string',
            'quotation_id' => 'required',
        ]);
    }

    public function setData(Request $request, $quotation_id){
        return [
          'type' => $request->input('accounting_radio'),
          'quotation_id' => $quotation_id,
        ];
    }

    public function store(Request $request, $quotation_id){
        $data = $this->setData($request, $quotation_id);
        if($data['type'] == 'm' && !is_null($request->input('accounting_months'))){
            $data['value'] = $request->input('accounting_monthly_value');
            $data['months'] = implode(",", $request->input('accounting_months'));
        } elseif($data['type'] == 'y' && !is_null($request->input('accounting_years'))) {
            $data['value'] = $request->input('accounting_yearly_value');
            $data['years'] = implode(",", $request->input('accounting_years'));
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
        if($data['type'] == 'm'){
            $data['value'] = $request->input('accounting_monthly_value');
            $data['months'] = implode(",", $request->input('accounting_months'));
        } elseif($data['type'] == 'y') {
            $data['value'] = $request->input('accounting_yearly_value');
            $data['years'] = implode(",", $request->input('accounting_years'));
        }

        $validator = $this->validation($data);
        if($validator->fails()){
            throw new ValidationException($validator);
        }

        $this->model()->where('quotation_id', $quotation_id)->delete();

        $this->model()->create($data);

        return 'success';
    }
}