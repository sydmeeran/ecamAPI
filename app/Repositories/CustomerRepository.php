<?php
/**
 * Created by PhpStorm.
 * User: damon
 * Date: 12/11/18
 * Time: 11:13 AM
 */

namespace App\Repositories;

use App\Customer;
use App\Mail\CustomerVerificationEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class CustomerRepository extends BaseRepository
{
    protected $prefix, $business;

    public function __construct()
    {
        $this->prefix = "AC".date('y');
        $this->business = DataRepo::business();
    }

    public function model(){
        return Customer::query();
    }

    public function validation(Request $request){
        return Validator::make($request->all(), [
            'company_name' => 'required|string',

            'business_name' => 'required',
            'license_no' => 'required',
            'license_type' => 'required',
            'license_photo' => 'required',
            'license_photo.*' => 'image|mimes:jpeg,png,jpg|max:2048',
            'address' => 'required',

            'owner_name' => 'required|string',
            'nrc_no' => 'required|string',
            'nrc_photo' => 'required',
            'nrc_photo.*' => 'image|mimes:jpeg,png,jpg|max:2048',
            'phone_no' => 'required|string|max:12',
            'email' => 'required|email|unique:customers,email',

            'contact_name' => 'required|string',
            'contact_position' => 'required|string',
            'contact_number' => 'required|string',
            'contact_email' => 'required|email',

            'company_dica_link' => 'string',
            'company_link' => 'string',
            'otp' => 'required|string'
        ]);
    }

    public function setData(Request $request, $nrc_photo_name){
        $customer_data = [
            'company_name' => $request->input('company_name'),

            'owner_name' => $request->input('owner_name'),
            'nrc_no' => $request->input('nrc_no'),
            'nrc_photo' => $nrc_photo_name,
            'phone_no' => $request->input('phone_no'),
            'email' => $request->input('email'),

            'contact_name' => $request->input('contact_name'),
            'contact_position' => $request->input('contact_position'),
            'contact_number' => $request->input('contact_number'),
            'contact_email' => $request->input('contact_email'),

            'company_dica_link' => $request->input('company_dica_link'),
            'company_link' => $request->input('company_link'),
            'otp' => $request->input('otp'),
        ];
        return $customer_data;
    }

    public function storeNrcPhoto(Request $request){
        /**
         * @var UploadedFile $nrc_photo
         */
        $nrc_photo = $request->file('nrc_photo');
        $nrc_photo_name = $nrc_photo->move(public_path('db/nrc_photos'), $this->uuid(date('m'), 15).'.'.$nrc_photo->getClientOriginalExtension());
        return 'db/nrc_photos/'.$nrc_photo_name->getFilename();

    }

    public function store(Request $request){
        $validator = $this->validation($request);
        $business_validator = $this->business->validation($request);

        if ($validator->fails()) {
            return $validator;
        } elseif ($business_validator->fails()) {
            return $business_validator;
        }
        $nrc_photo_name = $this->storeNrcPhoto($request);

        $data = $this->setData($request, $nrc_photo_name);
        $data['company_id'] = $this->generateCompanyId();

        $customer = $this->model()->create($data);

        Mail::to($customer->email)->send(new CustomerVerificationEmail($customer));

        return $this->business->store($request, $customer->id);
    }

    protected function generateCompanyId(){
        $company_id = $this->prefix.generateCode(4);
        while($this->model()->where('company_id', $company_id)->exists()){
            $company_id = $this->prefix.generateCode(4);
        }
        return $company_id;
    }

    public function updateValidation(Request $request){
        if($this->model()->where('email', $request->input('email'))->exists()){
            return Validator::make($request->all(), [
                'company_name' => 'required|string',
                'owner_name' => 'required|string',
                'nrc_no' => 'required|string',
                'nrc_photo' => 'required',
                'nrc_photo.*' => 'image|mimes:jpeg,png,jpg,svg|max:2048',
                'phone_no' => 'required|string|max:12',
                'email' => 'required|email',

                'contact_name' => 'required|string',
                'contact_position' => 'required|string',
                'contact_number' => 'required|string',
                'contact_email' => 'required|email',

                'company_dica_link' => 'string',
                'company_link' => 'string',
                'otp' => 'required|string'
            ]);
        }
        return $this->validation($request);
    }

    public function updateNrcPhoto(Request $request, $id){
        if (Input::hasFile('nrc_photo')) {
            $customer = $this->find($id);
            if(file_exists($customer->nrc_photo)){
                unlink($customer->nrc_photo);
            }
        }
        return $this->storeNrcPhoto($request);
    }

    public function update(Request $request, $id){
        $validator = $this->updateValidation($request);
        if ($validator->fails()) {
            return $validator;
        }

        $nrc_photo_name = $this->updateNrcPhoto($request, $id);

        $data = $this->setData($request, $nrc_photo_name);

        $this->model()->where('id', $id)->update($data);
//        Mail::to($customer->email)->send(new CustomerVerificationEmail($customer));
        return 'success';
//        return $this->business->update($request, $id);
    }


}