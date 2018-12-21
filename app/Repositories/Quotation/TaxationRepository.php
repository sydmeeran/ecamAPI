<?php
/**
 * Created by PhpStorm.
 * User: damon
 * Date: 12/20/18
 * Time: 5:16 PM
 */

namespace App\Repositories\Quotation;


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
        return Validator::make($data, [
            'quotation_id' => 'required',
            'month' => 'required',
        ]);
    }

    public function store(Request $request, $quotation_id){
        $months = $request->input('taxation_months');
        foreach($months as $month){
            $data = [
                'quotation_id' => $quotation_id,
                'month' => $month
            ];
            $validator = $this->validation($data);
            if($validator->fails()){
                throw new ValidationException($validator);
            }
            $this->model()->create($data);
        }
    }
}