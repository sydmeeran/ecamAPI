<?php

namespace App\Http\Controllers;

use App\Customer;
use App\Mail\CustomerVerificationEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class CustomerController extends BaseController
{
    /**
     * login api
     *
     * @return \Illuminate\Http\Response
     */
//    public function login(Request $request){
//        $customer = Customer::whereEmail($request->get('email'))->first();
//        if(Hash::check($request->get('password'), $customer->password)) {
//            $success['token'] =  $customer->createToken('api-customer')->accessToken;
//            return $this->success_login_response($success);
//        }else{
//            return response()->json($this->unauthorized);
//        }
//    }

    /**
     * Register api
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        if ($this->check_api_key($request)) {
            if ($this->check_permission('customer-create')) {

                $data = [
                    'business_name' => $request->input('business_name'),
                    'license_no' => $request->input('license_no'),
                    'license_type' => $request->input('license_type'),
                    'address' => $request->input('address'),
                    'owner_name' => $request->input('owner_name'),
                    'nrc_no' => $request->input('nrc_no'),
                    'phone_no' => $request->input('phone_no'),
                    'email' => $request->input('email'),
                    'contact_name' => $request->input('contact_name'),
                    'contact_position' => $request->input('contact_position'),
                    'contact_number' => $request->input('contact_number'),
                    'contact_email' => $request->input('contact_email'),
                    'otp' => $request->input('otp'),
                ];


                $validator = Validator::make($request->all(), [
                    'business_name' => 'required|string',
                    'license_no' => 'required|string',
                    'license_type' => 'required|string',
                    'address' => 'required|string',
                    'owner_name' => 'required|string',
                    'nrc_no' => 'required|string',
                    'phone_no' => 'required|string|max:12',
                    'email' => 'required|email|unique:customers,email',
                    'contact_name' => 'required|string',
                    'contact_position' => 'required|string',
                    'contact_number' => 'required|string',
                    'contact_email' => 'required|email',
                    'otp' => 'required|string'
                ]);

                if ($validator->fails()) {
                    return $this->errors($validator);
                }

                $customer = Customer::create($data);

                Mail::to($customer->email)->send(new CustomerVerificationEmail($data));

                return response()->json($this->success);
            }
            return response()->json($this->permission_denied);
        }
        return response()->json($this->unauthorized);
    }

    public function update(Request $request, $id)
    {
        if ($this->check_api_key($request)) {
            if ($this->check_permission('customer-update')) {

                $data = [
                    'business_name' => $request->input('business_name'),
                    'license_no' => $request->input('license_no'),
                    'license_type' => $request->input('license_type'),
                    'address' => $request->input('address'),
                    'owner_name' => $request->input('owner_name'),
                    'nrc_no' => $request->input('nrc_no'),
                    'phone_no' => $request->input('phone_no'),
                    'email' => $request->input('email'),
                    'contact_name' => $request->input('contact_name'),
                    'contact_position' => $request->input('contact_position'),
                    'contact_number' => $request->input('contact_number'),
                    'contact_email' => $request->input('contact_email'),
                ];

                $customer = Customer::where('id', $id)->get()->toArray();

                if($data['email'] == $customer[0]['email']){
                    $validator = Validator::make($request->all(), [
                        'business_name' => 'required|string',
                        'license_no' => 'required|string',
                        'license_type' => 'required|string',
                        'address' => 'required|string',
                        'owner_name' => 'required|string',
                        'nrc_no' => 'required|string',
                        'phone_no' => 'required|string|max:12',
                        'email' => 'required|email',
                        'contact_name' => 'required|string',
                        'contact_position' => 'required|string',
                        'contact_number' => 'required|string',
                        'contact_email' => 'required|email',
                    ]);
                } else {
                    $validator = Validator::make($request->all(), [
                        'business_name' => 'required|string',
                        'license_no' => 'required|string',
                        'license_type' => 'required|string',
                        'address' => 'required|string',
                        'owner_name' => 'required|string',
                        'nrc_no' => 'required|string',
                        'phone_no' => 'required|string|max:12',
                        'email' => 'required|email',
                        'contact_name' => 'required|string',
                        'contact_position' => 'required|string',
                        'contact_number' => 'required|string',
                        'contact_email' => 'required|email',
                    ]);
                }

                if ($validator->fails()) {
                    return $this->errors($validator);
                }

                Customer::where('id', $id)->update($data);

//                Mail::to($customer->email)->send(new CustomerVerificationEmail($data));

                return response()->json($this->success);
            }
            return response()->json($this->permission_denied);
        }
        return response()->json($this->unauthorized);
    }

    public function use(Request $request){
        $email = $request->input('email');
        $otp = $request->input('otp');

        Customer::where('email', $email)->where('otp', $otp)->update([
            'is_use' => 1
        ]);

        return redirect('https://www.google.com');
    }

    function generateCode($length = 8) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
    /**
     * details api
     *
     * @return \Illuminate\Http\Response
     */
//    public function details(Request $request)
//    {
//        $user = $this->customer->model()->whereEmail($request->header('email'))->get();
//        return response()->json($user);
//    }

//    public function logout(Request $request){
//        $customer = $this->customer->model()->whereEmail($request->get('email'))->exists();
//        if($customer) {
//            $request->user()->token()->delete();
//            return response()->json(['status_code' => $this-> successStatus]);
//        }
//        return response()->json(['error'=>'Unauthorised'], 401);
//    }

//    public function login()
//    {
//        if (Auth::attempt(['email' => request('email'), 'password' => request('password')])) {
//            $user = Auth::user();
//            $success['token'] = $user->createToken('api')->accessToken;
//            return $this->success_login_response($success);
//        } else {
//            return response()->json($this->unauthorized);
//        }
//    }

//    public function register(Request $request)
//    {
//        if ($this->check_api_key($request)) {
//            if ($this->check_permission('user-create')) {
//
//                $data = [
//                    'name' => $request->get('name'),
//                    'email' => $request->get('email'),
//                    'password' => bcrypt($request->get('password')),
//                    'role_id' => $request->get('role_id')
//                ];
//
//                $validator = Validator::make($data, [
//                    'name' => 'required',
//                    'email' => 'required|unique:users',
//                    'password' => 'required',
//                    'role_id' => 'required|int'
//                ]);
//
//                if ($validator->fails()) {
//                    return $this->errors($validator);
//                }
//
//                User::create($data);
//
//                return response()->json($this->success);
//            }
//            return response()->json($this->permission_denied);
//        }
//        return response()->json($this->unauthorized);
//    }
//
//    public function logout(Request $request)
//    {
//        if ($this->check_api_key($request)) {
//
//            $request->user()->token()->delete();
//
//            return response()->json($this->success);
//        }
//        return response()->json($this->unauthorized);
//    }

//    public function auth_user(Request $request)
//    {
//        if ($this->check_api_key($request)) {
//            $user = Auth::user()->toArray();
//            $role = Role::where('id', $user['role_id'])->with('permissions')->get(['id', 'role'])->toArray();
//            $user['role'] = $role[0];
//            return $this->response($user);
//        }
//        return response()->json($this->unauthorized);
//    }

    public function getAll(Request $request)
    {
        if ($this->check_api_key($request)) {
            if($this->check_permission('customer-retrieve')){
                $user = Customer::all()->toArray();
                return $this->response($user);
            }
            return response()->json($this->permission_denied);
        }
        return response()->json($this->unauthorized);
    }

    public function getAll_pagination(Request $request)
    {
        if ($this->check_api_key($request)) {
            if($this->check_permission('customer-retrieve')){
                $customer = Customer::paginate(20);
                return $this->response($customer);
            }
            return response()->json($this->permission_denied);
        }
        return response()->json($this->unauthorized);
    }

    public function get(Request $request, $id)
    {
        if ($this->check_api_key($request)) {

            if($this->check_permission('customer-retrieve')){
                $user = Customer::where('id', $id)->get()->toArray();
                if(empty($user)){
                    return $this->response($user);
                }
                $user = $user[0];
                return $this->response($user);
            }

            return response()->json($this->permission_denied);
        }
        return response()->json($this->unauthorized);
    }

    public function search(Request $request){
        if ($this->check_api_key($request)) {

            if($this->check_permission('customer-retrieve')){
                $keyword = $request->get('keyword');
                $result = Customer::where ( 'name', 'LIKE', '%' . $keyword . '%' )
                    ->orWhere ( 'email', 'LIKE', '%' . $keyword . '%' )
                    ->orWhere ( 'phone_no', 'LIKE', '%' . $keyword . '%' )
                    ->orWhere ( 'address', 'LIKE', '%' . $keyword . '%' )
                    ->get()->toArray();

                return $this->response($result);
            }

            return response()->json($this->permission_denied);
        }
        return response()->json($this->unauthorized);
    }

    public function active_deactive(Request $request, $id){
        if ($this->check_api_key($request)) {

            if($this->check_permission('customer-update')){

                Customer::where('id', $id)->update([
                    'is_active' => $request->get('status')
                ]);
                return response()->json($this->success);

            }
            return response()->json($this->permission_denied);
        }
        return response()->json($this->unauthorized);
    }

    public function append_suspend(Request $request, $id){
        if ($this->check_api_key($request)) {

            if($this->check_permission('customer-update')){

                Customer::where('id', $id)->update([
                    'is_suspend' => $request->get('status')
                ]);
                return response()->json($this->success);

            }
            return response()->json($this->permission_denied);
        }
        return response()->json($this->unauthorized);
    }

    public function delete(Request $request, $id){
        if ($this->check_api_key($request)) {

            if($this->check_permission('customer-delete')){
                Customer::where('id', $id)->delete();
                return response()->json($this->success);
            }

            return response()->json($this->permission_denied);
        }
        return response()->json($this->unauthorized);
    }
}
