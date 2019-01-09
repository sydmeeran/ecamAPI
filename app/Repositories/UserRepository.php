<?php
/**
 * Created by PhpStorm.
 * User: damon
 * Date: 12/11/18
 * Time: 11:13 AM
 */

namespace App\Repositories;

use App\Mail\CustomerVerificationEmail;
use App\Transformers\UserTransformer;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class UserRepository extends BaseRepository
{
    protected $prefix, $business;

    public function model()
    {
        return User::query();
    }

    public function validation(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|unique:users',
            'position' => 'required|string',
            'nrc_no' => 'required|string',
            'nrc_photo' => 'required',
            'nrc_photo.*' => 'image|mimes:jpeg,png,jpg|max:2048',
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

    public function setData(Request $request)
    {
        $data = [
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'position' => $request->get('position'),
            'nrc_no' => $request->get('nrc_no'),
            'phone_no' => $request->get('phone_no'),
            'address' => $request->get('address'),
            'password' => bcrypt($request->get('password')),
            'role_id' => $request->get('role_id'),
        ];

        return $data;
    }

    public function storeProfilePhoto(Request $request)
    {
        /**
         * @var UploadedFile $profile_photo
         */
        $profile_photo = $request->file('profile_photo');
        $profile_photo_name = $profile_photo->move(public_path('db/profile_photos'), $this->uuid(date('m'), 15) . '.' . $profile_photo->getClientOriginalExtension());

        return 'db/profile_photos/' . $profile_photo_name->getFilename();
    }

    public function storeNrcPhoto(Request $request)
    {
        /**
         * @var UploadedFile $nrc_photo
         */
        $nrc_photo = $request->file('nrc_photo');
        $nrc_photo_name = $nrc_photo->move(public_path('db/nrc_photos'), $this->uuid(date('m'), 15) . '.' . $nrc_photo->getClientOriginalExtension());

        return 'db/nrc_photos/' . $nrc_photo_name->getFilename();
    }

    public function store(Request $request)
    {
        $validator = $this->validation($request);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        $profile_photo_name = $this->storeProfilePhoto($request);
        $nrc_photo_name = $this->storeNrcPhoto($request);

        $data = $this->setData($request);

        $data['profile_photo'] = $profile_photo_name;
        $data['nrc_photo'] = $nrc_photo_name;

//        $user = $this->model()->create($data);
        return $this->model()->create($data);

        //        Mail::to($user->email)->send(new CustomerVerificationEmail($user));
//        return 'success';
    }

    //    protected function generateCompanyId(){
    //        $company_id = $this->prefix.generateCode(4);
    //        while($this->model()->where('company_id', $company_id)->exists()){
    //            $company_id = $this->prefix.generateCode(4);
    //        }
    //        return $company_id;
    //    }

    public function setUpdateProfileData(Request $request)
    {
        if(isset($request->password)){
            $data = [
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'position' => $request->get('position'),
            'nrc_no' => $request->get('nrc_no'),
            'phone_no' => $request->get('phone_no'),
            'address' => $request->get('address'),
            'role_id' => $request->get('role_id'),
            'password' => bcrypt($request->get('password')),
        ];

        return $data;
        }else{
            $data = [
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'position' => $request->get('position'),
            'nrc_no' => $request->get('nrc_no'),
            'phone_no' => $request->get('phone_no'),
            'address' => $request->get('address'),
            'role_id' => $request->get('role_id'),
        ];

        return $data;    
        }
        
    }

    public function updateProfileValidation(Request $request)
    {
        if(isset($request->password)){
            return Validator::make($request->all(), [
            'name' => 'required',
            'email' => $this->model()->where('email', $request->input('email'))->exists() ? 'required' : 'required|unique:users',
            'position' => 'required|string',
            'nrc_no' => 'required|string',
            'nrc_photo' => 'image|mimes:jpeg,png,jpg|max:2048',
            'phone_no' => 'required|string',
            'address' => 'required|string',
            'role_id' => 'required|int',
            'profile_photo' => 'image|mimes:jpeg,png,jpg|max:2048',
            'password' => 'required',
            'confirm_password' => 'required|same:password'
        ]);
        }else{
            return Validator::make($request->all(), [
            'name' => 'required',
            'email' => $this->model()->where('email', $request->input('email'))->exists() ? 'required' : 'required|unique:users',
            'position' => 'required|string',
            'nrc_no' => 'required|string',
            'nrc_photo' => 'image|mimes:jpeg,png,jpg|max:2048',
            'phone_no' => 'required|string',
            'address' => 'required|string',
            'role_id' => 'required|int',
            'profile_photo' => 'image|mimes:jpeg,png,jpg|max:2048',
        ]);  
        }
        
    }

    public function update_profile(Request $request, $id)
    {

        $validator = $this->updateProfileValidation($request);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        $data = $this->setUpdateProfileData($request);

        $user = $this->find($id);
        if (Input::hasFile('profile_photo')) {

            if (file_exists($user->profile_photo)) {
                unlink($user->profile_photo);
            }
            $profile_photo_name = $this->storeProfilePhoto($request);
            $data['profile_photo'] = $profile_photo_name;
        }

        if (Input::hasFile('nrc_photo')) {

            if (file_exists($user->nrc_photo)) {
                unlink($user->nrc_photo);
            }
            $nrc_photo_name = $this->storeNrcPhoto($request);
            $data['nrc_photo'] = $nrc_photo_name;
        }
        
        return $this->model()->where('id', $id)->update($data);

        //        Mail::to($customer->email)->send(new CustomerVerificationEmail($customer));

    }

    public function updatePasswordValidation($data)
    {
        return Validator::make($data, [
            'current_password' => 'required|string|old_password',
            'new_password' => 'required|string',
            'confirm_password' => 'required|same:new_password',
        ]);
    }

    public function update_password(Request $request, $id)
    {
        $data = [
            'current_password' => $request->get('current_password'),
            'new_password' => $request->get('new_password'),
            'confirm_password' => $request->get('confirm_password'),
        ];
        $validator = $this->updatePasswordValidation($data);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        $password_data = [
            'password' => bcrypt($data['new_password']),
        ];

        return $this->model()->where('id', $id)->update($password_data);

        //        Mail::to($customer->email)->send(new CustomerVerificationEmail($customer));

    }

}
