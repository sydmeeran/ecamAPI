<?php
/**
 * Created by PhpStorm.
 * User: damon
 * Date: 12/11/18
 * Time: 11:13 AM
 */

namespace App\Repositories;

use App\Member;
use App\Mail\MemberVerificationEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class MemberRepository extends BaseRepository
{
    protected $prefix, $business;

    public function __construct()
    {
        $this->prefix = "AC".date('y');
        $this->business = DataRepo::business();
    }

    public function model(){
        return Member::query();
    }

    public function validation(Request $request){
        return Validator::make($request->all(), [
            'company_name' => 'required|string',

            'owner_name' => 'required|string',
            'nrc_no' => 'required|string',
            'nrc_photo.*' => 'image|mimes:jpeg,png,jpg|max:2048',
            'phone_no' => 'required|string|max:12',
            'email' => 'required|email|unique:members,email',

            'contact_name' => 'string',
            'contact_position' => 'string',
            'contact_number' => 'string',
            'contact_email' => 'email',

            'company_dica_link' => 'string',
            'company_link' => 'string',
            'otp' => 'required|string'
        ]);
    }

    public function setData(Request $request){
        $member_data = [
            'company_name' => $request->input('company_name'),

            'owner_name' => $request->input('owner_name'),
            'nrc_no' => $request->input('nrc_no'),
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
        return $member_data;
    }

    public function editSetData(Request $request){
        $member_data = [
            'company_name' => $request->input('company_name'),

            'owner_name' => $request->input('owner_name'),
            'nrc_no' => $request->input('nrc_no'),
            'phone_no' => $request->input('phone_no'),
            'email' => $request->input('email'),

            'contact_name' => $request->input('contact_name'),
            'contact_position' => $request->input('contact_position'),
            'contact_number' => $request->input('contact_number'),
            'contact_email' => $request->input('contact_email'),

            'company_dica_link' => $request->input('company_dica_link'),
            'company_link' => $request->input('company_link'),
        ];
        return $member_data;
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
            throw new ValidationException($validator);
        } elseif ($business_validator->fails()) {
            throw new ValidationException($business_validator);
        }

        $data = $this->setData($request);
        if(Input::hasFile('nrc_photo')) {
            $nrc_photo_name = $this->storeNrcPhoto($request);
            $data['nrc_photo'] = $nrc_photo_name;
        } else {
            $data['nrc_photo'] = null;
        }
        $data['company_id'] = $this->generateCompanyId();

        $member = $this->model()->create($data);

//        Mail::to($member->email)->send(new MemberVerificationEmail($member));

        return $this->business->store($request, $member->id);
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
                'nrc_photo.*' => 'image|mimes:jpeg,png,jpg,svg|max:2048',
                'phone_no' => 'required|string|max:12',
                'email' => 'required|email',

                'contact_name' => 'string',
                'contact_position' => 'string',
                'contact_number' => 'string',
                'contact_email' => 'email',

                'company_dica_link' => 'string',
                'company_link' => 'string',
            ]);
        }
        return Validator::make($request->all(), [
            'company_name' => 'required|string',
            'owner_name' => 'required|string',
            'nrc_no' => 'required|string',
            'nrc_photo.*' => 'image|mimes:jpeg,png,jpg,svg|max:2048',
            'phone_no' => 'required|string|max:12',
            'email' => 'required|email|unique:members,email',

            'contact_name' => 'string',
            'contact_position' => 'string',
            'contact_number' => 'string',
            'contact_email' => 'email',

            'company_dica_link' => 'string',
            'company_link' => 'string',
        ]);
    }

//    public function updateNrcPhoto(Request $request, $id){
//        if (Input::hasFile('nrc_photo')) {
//            $member = $this->find($id);
//            if(file_exists($member->nrc_photo)){
//                unlink($member->nrc_photo);
//            }
//        }
//        return $this->storeNrcPhoto($request);
//    }

    public function update(Request $request, $id){
        $validator = $this->updateValidation($request);

        if ($validator->fails()) {
            return $validator;
        }

        $data = $this->editSetData($request);

        if (Input::hasFile('nrc_photo')) {
            $member = $this->find($id);
            if(file_exists($member->nrc_photo)){
                unlink($member->nrc_photo);
            }
            $nrc_photo_name = $this->storeNrcPhoto($request);
            $data['nrc_photo'] = $nrc_photo_name;
        }

        $this->model()->where('id', $id)->update($data);

        return 'success';
//        Mail::to($member->email)->send(new MemberVerificationEmail($member));

//        return $this->business->update($request, $id);
    }


}