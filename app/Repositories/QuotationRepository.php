<?php
/**
 * Created by PhpStorm.
 * User: damon
 * Date: 12/20/18
 * Time: 4:49 PM
 */

namespace App\Repositories;


use App\AccountingService;
use App\Quotation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class QuotationRepository extends BaseRepository
{
    protected $monthly_accounting_service, $auditing, $annual, $consulting, $taxation;

    public function __construct()
    {
        $this->monthly_accounting_service = DataRepo::monthly_accounting_service();
        $this->auditing = DataRepo::auditing();
        $this->annual = DataRepo::annual();
        $this->consulting = DataRepo::consulting();
        $this->taxation = DataRepo::taxation();
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

        if($data['accounting_service']){
            $this->monthly_accounting_service->store($request, $quotation->id);
        }
        if($data['auditing']){
            $this->auditing->store($request, $quotation->id);
        }
        if($data['consulting']){
            $this->consulting->store($request, $quotation->id);
        }
        if($data['taxation']){
            $this->taxation->store($request, $quotation->id);
        }

        return 'success';
    }
}