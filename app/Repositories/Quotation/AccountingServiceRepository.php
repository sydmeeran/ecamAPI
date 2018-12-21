<?php
/**
 * Created by PhpStorm.
 * User: damon
 * Date: 12/20/18
 * Time: 5:16 PM
 */

namespace App\Repositories\Quotation;


use App\AccountingService;
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
        return Validator::make($data, [
            'type' => 'required',
            'value' => 'required',
            'months' => 'string',
            'years' => 'string',
            'quotation_id' => 'required',
        ]);
    }

    public function setData(Request $request, $quotation_id){
        return [
          'type' => $request->input('type'),
          'value' => $request->input('value'),
          'months' => $request->input('months'),
          'years' => $request->input('years'),
          'quotation_id' => $quotation_id,
        ];
    }

    public function store(Request $request, $quotation_id){
        $data = $this->setData($request, $quotation_id);

        $validator = $this->validation($data);
        if($validator->fails()){
            throw new ValidationException($validator);
        }

        $this->model()->create($data);

        return 'success';
    }
}