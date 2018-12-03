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
                    'name' => $request->get('name'),
                    'email' => $request->get('email'),
                    'phone_no' => $request->get('phone_no'),
                    'address' => $request->get('address'),
                    'password' => bcrypt($request->get('password')),
                    'code' => $this->generateCode()
                ];


                $validator = Validator::make($request->all(), [
                    'name' => 'required',
                    'email' => 'required|email|unique:customers,email',
                    'phone_no' => 'required|string|max:12',
                    'address' => 'required|string',
                    'password' => 'required|string',
                    'confirm_password' => 'required|same:password',
                ]);

                if ($validator->fails()) {
                    return $this->errors($validator);
                }


                $customer = Customer::create($data);

//                Mail::to($customer->email)->send(new CustomerVerificationEmail($data));

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
                    'name' => $request->get('name'),
                    'email' => $request->get('email'),
                    'phone_no' => $request->get('phone_no'),
                    'address' => $request->get('address'),
                ];

                $customer = Customer::where('id', $id)->get()->toArray();

                if($data['email'] == $customer[0]['email']){
                    $validator = Validator::make($request->all(), [
                        'name' => 'required',
                        'email' => 'required|email',
                        'phone_no' => 'required|string|max:12',
                        'address' => 'required|string'
                    ]);
                } else {
                    $validator = Validator::make($request->all(), [
                        'name' => 'required',
                        'email' => 'required|email|unique:customers,email',
                        'phone_no' => 'required|string|max:12',
                        'address' => 'required|string'
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

    public function verify(Request $request){
        $email = $request->input('email');
        $code = $request->input('code');

        Customer::where('email', $email)->where('code', $code)->update([
            'is_confirm' => 1
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
            return response()->json($this->unauthorized);
        }
        return response()->json($this->unauthorized);
    }

    public function getAll_pagination(Request $request)
    {
        if ($this->check_api_key($request)) {
            if($this->check_permission('customer-retrieve')){
                $customer = Customer::paginate(20);
//                dd($customer);
                return $this->response($customer);
            }
            return response()->json($this->unauthorized);
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

            return response()->json($this->unauthorized);
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

            return response()->json($this->unauthorized);
        }
        return response()->json($this->unauthorized);
    }

    public function delete(Request $request, $id){
        if ($this->check_api_key($request)) {

            if($this->check_permission('customer-delete')){
                Customer::where('id', $id)->delete();
                return response()->json($this->success);
            }

            return response()->json($this->unauthorized);
        }
        return response()->json($this->unauthorized);
    }
}
