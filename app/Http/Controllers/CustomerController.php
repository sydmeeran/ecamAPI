<?php

namespace App\Http\Controllers;

use App\Business;
use App\Customer;
use App\Exceptions\EmptyCustomerException;
use App\Mail\CustomerVerificationEmail;

use App\Repositories\DataRepo;
use Arga\Utils\ActionMiddlewareTrait;
use http\Env\Response;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class CustomerController extends BaseController
{
    use ActionMiddlewareTrait;

    protected $customer;

    public function __construct()
    {
        $this->customer = DataRepo::customer();

        $this->actionMiddleware([
            'register' => 'customer-create',
            'pagination' => 'customer-retrieve',
            'update' => 'customer-update',
            'get' => 'customer-retrieve',
            'search' => 'customer-retrieve',
            'active_deactive' => 'customer-deactive',
            'append_suspend' => 'customer-suspend',
            'delete' => 'customer-delete',
            'send_mail' => 'customer-create'
        ]);
    }

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

            return $this->customer->store($request);

        }
        return $this->unauthorized();
    }

    public function update(Request $request, $id)
    {
        if ($this->check_api_key($request)) {

            return $this->customer->update($request, $id);
        }
        return $this->unauthorized();
    }

    public function use(Request $request)
    {
        $email = $request->input('email');
        $otp = $request->input('otp');

        $this->customer->model()->where('email', $email)->where('otp', $otp)->update([
            'is_use' => 1
        ]);

        return redirect('https://www.google.com');
    }

    public function send_mail(Request $request, $id)
    {
        if ($this->check_api_key($request)) {
            $customer = $this->customer->find($id)->toArray();
            Mail::to($customer['email'])->send(new CustomerVerificationEmail($customer));
            return 'success';
        }
        return $this->unauthorized();
    }

    function generateCode($length = 8)
    {
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
//            if($this->check_permission('customer-retrieve')){

            $user = $this->customer->getAll();
            if (empty($user)) {
                throw new EmptyCustomerException();
            }
            return $this->response($user);
//            }
//            return $this->permission_denied();
        }
        return $this->unauthorized();
    }

    public function getAllByJobEntry(Request $request)
    {
        if ($this->check_api_key($request)) {
            $user = $this->customer->getAll();
            if (empty($user)) {
                throw new EmptyCustomerException();
            }
            return $this->response($user);
        }
        return $this->unauthorized();
    }

    public function pagination(Request $request)
    {
        if ($this->check_api_key($request)) {

            $customer = $this->customer->paginate(20);
            return $this->response($customer);

        }
        return $this->unauthorized();
    }

    public function get(Request $request, $id)
    {
        if ($this->check_api_key($request)) {

            $user = $this->customer->with(['businesses'], $id)->toArray();
            if (empty($user)) {
                return $this->empty_data();
            }
            $user = $user[0];
            return $this->response($user);

        }
        return $this->unauthorized();
    }

    public function search(Request $request)
    {
        if ($this->check_api_key($request)) {

            $keyword = $request->get('keyword');
            $result = $this->customer->model()->where('owner_name', 'LIKE', '%' . $keyword . '%')
                ->orWhere('email', 'LIKE', '%' . $keyword . '%')
                ->orWhere('phone_no', 'LIKE', '%' . $keyword . '%')
                ->orWhere('company_name', 'LIKE', '%' . $keyword . '%')
                ->orWhere('company_id', 'LIKE', '%' . $keyword . '%')
                ->get()->toArray();

            return $this->response($result);
        }
        return $this->unauthorized();
    }

    public function active_deactive(Request $request, $id)
    {
        if ($this->check_api_key($request)) {


            $this->customer->model()->where('id', $id)->update([
                'is_active' => $request->get('status')
            ]);
            return $this->success();

        }
        return $this->unauthorized();
    }

    public function append_suspend(Request $request, $id)
    {
        if ($this->check_api_key($request)) {


            $this->customer->model()->where('id', $id)->update([
                'is_suspend' => $request->get('status')
            ]);
            return $this->success();

        }
        return $this->unauthorized();
    }

    public function delete(Request $request, $id)
    {
        if ($this->check_api_key($request)) {

            $this->customer->model()->where('id', $id)->delete();
            return $this->success();

        }
        return $this->unauthorized();
    }

    protected function combine_array($business_name_arrs, $license_no_arrs, $license_type_arrs, $license_photo_arrs, $address_arrs)
    {
        $result = array_map(function ($business_name_arrs, $license_no_arrs, $license_type_arrs, $license_photo_arrs, $address_arrs) {
            return array_combine(
                ['business_name', 'license_no', 'license_type', 'license_photo', 'address'],
                [$business_name_arrs, $license_no_arrs, $license_type_arrs, $license_photo_arrs, $address_arrs]
            );
        }, $business_name_arrs, $license_no_arrs, $license_type_arrs, $license_photo_arrs, $address_arrs);

        return $result;
    }
}
