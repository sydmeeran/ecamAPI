<?php
/**
 * Created by PhpStorm.
 * User: damon
 * Date: 12/11/18
 * Time: 11:13 AM
 */

namespace App\Repositories;

use App\Mail\CustomerVerificationEmail;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class UserRepository extends BaseRepository
{
    protected $prefix, $business;

    public function model(){
        return User::query();
    }

    public function validation(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|unique:users',
            'position' => 'required|string',
            'nrc_no' => 'required|string',
            'phone_no' => 'required|string',
            'address' => 'required|string',
            'password' => 'required',
            'confirm_password' => 'required|same:password',
            'role_id' => 'required|int',
            'profile_photo' => 'required',
            'profile_photo.*' => 'image|mimes:jpeg,png,jpg|max:2048',
        ]);
        return $validator;
    }

    public function setData(Request $request){
        $data = [
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'position' => $request->get('position'),
            'nrc_no' => $request->get('nrc_no'),
            'phone_no' => $request->get('phone_no'),
            'address' => $request->get('address'),
            'password' => bcrypt($request->get('password')),
            'role_id' => $request->get('role_id')
        ];
        return $data;
    }

    public function storeProfilePhoto(Request $request){
        /**
         * @var UploadedFile $nrc_photo
         */
        $profile_photo = $request->file('profile_photo');
        $profile_photo_name = $profile_photo->move(public_path('db/profile_photos'), $this->uuid(date('m'), 15).'.'.$profile_photo->getClientOriginalExtension());
        return 'db/profile_photos/'.$profile_photo_name->getFilename();

    }

    public function store(Request $request){
        $validator = $this->validation($request);

        if ($validator->fails()) {
            return $validator;
        }

        $profile_photo_name = $this->storeProfilePhoto($request);

        $data = $this->setData($request);

        $data['profile_photo'] = $profile_photo_name;

        $user = $this->model()->create($data);

//        Mail::to($user->email)->send(new CustomerVerificationEmail($user));
        return 'success';
    }

//    protected function generateCompanyId(){
//        $company_id = $this->prefix.generateCode(4);
//        while($this->model()->where('company_id', $company_id)->exists()){
//            $company_id = $this->prefix.generateCode(4);
//        }
//        return $company_id;
//    }

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

//    public function updateNrcPhoto(Request $request, $id){
//        if (Input::hasFile('nrc_photo')) {
//            $customer = $this->find($id);
//            if(file_exists($customer->nrc_photo)){
//                unlink($customer->nrc_photo);
//            }
//        }
//        return $this->storeNrcPhoto($request);
//    }

    public function update(Request $request, $id){
        $validator = $this->updateValidation($request);

        if ($validator->fails()) {
            return $validator;
        }

        $data = $this->setData($request);

        if (Input::hasFile('nrc_photo')) {
            $customer = $this->find($id);
            if(file_exists($customer->nrc_photo)){
                unlink($customer->nrc_photo);
            }
            $nrc_photo_name = $this->storeNrcPhoto($request);
            $data['nrc_photo'] = $nrc_photo_name;
        }

        $this->model()->where('id', $id)->update($data);

        return 'success';
//        Mail::to($customer->email)->send(new CustomerVerificationEmail($customer));

//        return $this->business->update($request, $id);
    }


}