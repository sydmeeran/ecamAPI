<?php

namespace App\Http\Controllers\Frontend;

use App\Exceptions\EmptyMemberException;
use App\Mail\MemberContractEmail;
use App\Mail\MemberVerificationEmail;
use App\Repositories\DataRepo;
use Arga\Utils\ActionMiddlewareTrait;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Member;
use App\Business;

class MemberController extends BaseController
{
    // use ActionMiddlewareTrait;

    protected $member, $prefix;

    public function __construct()
    {
        $this->prefix = "AC".date('y');
        // $this->actionMiddleware([
        //     'store' => 'member-create',
        //     'pagination' => 'member-retrieve',
        //     'update' => 'member-update',
        //     'get' => 'member-retrieve',
        //     'search' => 'member-retrieve',
        //     'active_deactive' => 'member-deactive',
        //     'append_suspend' => 'member-suspend',
        //     'delete' => 'member-delete',
        //     'send_mail' => 'member-create'
        // ]);

        // $this->member = DataRepo::member();
    }

    /**
     * login api
     *
     * @return \Illuminate\Http\Response
     */
//    public function login(Request $request){
//        $member = Customer::whereEmail($request->get('email'))->first();
//        if(Hash::check($request->get('password'), $member->password)) {
//            $success['token'] =  $member->createToken('api-member')->accessToken;
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
    public function store(Request $request)
    {
        $request->validate([
            'company_name' => 'required|string',
            'phone_no' => 'required|string',
            'email' => 'required|email|unique:members,email',
            'business_name' => 'required|string',
            'license_type' => 'required|string',
            'facebook_url' => 'required|string',
            'website_url' => 'required|string',
            'otp' => 'required|string',
        ]);

        $member_data = $request->only('company_name', 'phone_no', 'email',
                 'business_name', 'license_type', 'facebook_url', 'website_url', 'otp');
        $member_data['company_dica_link'] = $member_data['facebook_url'];
        $member_data['company_link'] = $member_data['website_url'];

        unset($member_data['facebook_url']);
        unset($member_data['website_url']);

        $member_data['owner_name'] = $member_data['company_name'];
        $member_data['company_id'] = $this->generateCompanyId();
            
        // dd($member_data);
        $member = Member::create($member_data);

        $business_data = $request->only('business_name', 'license_type');
        $business_data['member_id'] = $member->id;

        Business::create($business_data);
        
        return $this->response($member);
    }

    protected function generateCompanyId(){
        $company_id = $this->prefix.generateCode(4);
        while(Member::where('company_id', $company_id)->exists()){
            $company_id = $this->prefix.generateCode(4);
        }
        return $company_id;
    }

    // public function update(Request $request, $id)
    // {
    //     return $this->member->update($request, $id);
    // }

    // public function use(Request $request)
    // {
    //     $email = $request->input('email');
    //     $otp = $request->input('otp');

    //     $this->member->model()->where('email', $email)->where('otp', $otp)->update([
    //         'is_use' => 1
    //     ]);

    //     return redirect('https://www.google.com');
    // }

    // public function send_mail($id)
    // {
    //     $member = $this->member->find($id)->toArray();
    //     Mail::to($member['email'])->send(new MemberVerificationEmail($member));
    //     return 'success';
    // }

    // public function send_contract($id)
    // {
    //     $member = $this->member->find($id)->toArray();
    //     if($member['contract']){
    //         Mail::to($member['email'])->send(new MemberContractEmail($member['contract']));
    //         $this->member->model()->where('id', $id)->update([
    //             'contract_date' => new \DateTime()
    //         ]);
    //     } else {
    //         $pdf_name = 'db/contracts/M'.$id.'_'.date('d-m-Y-H-m-s').'_'.generateCode(10).'.pdf';
    //         PDF::loadView('pdfs.member_contract', $member)->setPaper('A4', 'portrait')->save($pdf_name);
    //         $this->member->model()->where('id', $id)->update([
    //             'contract' => $pdf_name,
    //             'contract_date' => new \DateTime()
    //         ]);
    //         Mail::to($member['email'])->send(new MemberContractEmail($pdf_name));
    //     }
    //     return 'success';
    // }

    // public function verify(Request $request)
    // {
    //     $email = $request->input('email');
    //     $otp = $request->input('otp');

    //     $this->member->model()->where('email', $email)->where('otp', $otp)->update([
    //         'is_active' => 1
    //     ]);
    //     return 'success';
    // }

    /**
     * details api
     *
     * @return \Illuminate\Http\Response
     */
//    public function details(Request $request)
//    {
//        $user = $this->member->model()->whereEmail($request->header('email'))->get();
//        return response()->json($user);
//    }

//    public function logout(Request $request){
//        $member = $this->member->model()->whereEmail($request->get('email'))->exists();
//        if($member) {
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

    public function getAll()
    {
        $user = $this->member->getAll();
        if (empty($user)) {
            throw new EmptyMemberException();
        }
        return $this->response($user);
    }

    public function getAllByJobEntry()
    {
        $user = $this->member->getAll();
        if (empty($user)) {
            throw new EmptyMemberException();
        }
        return $this->response($user);
    }

    public function pagination()
    {
        $member = $this->member->paginate(20);
        return $this->response($member);
    }

    public function get($id)
    {
        $user = $this->member->with(['businesses'], $id)->toArray();
        if (empty($user)) {
            return $this->empty_data();
        }
        $user = $user[0];
        return $this->response($user);
    }

    public function search(Request $request)
    {
        $keyword = $request->get('keyword');
        $result = $this->member->model()->where('owner_name', 'LIKE', '%' . $keyword . '%')
            ->orWhere('email', 'LIKE', '%' . $keyword . '%')
            ->orWhere('phone_no', 'LIKE', '%' . $keyword . '%')
            ->orWhere('company_name', 'LIKE', '%' . $keyword . '%')
            ->orWhere('company_id', 'LIKE', '%' . $keyword . '%')
            ->get()->toArray();

        return $this->response($result);
    }

    public function active_deactive(Request $request, $id)
    {
        $this->member->model()->where('id', $id)->update([
            'is_active' => $request->get('status')
        ]);
        return $this->success();
    }

    public function append_suspend(Request $request, $id)
    {
        $this->member->model()->where('id', $id)->update([
            'is_suspend' => $request->get('status')
        ]);
        return $this->success();
    }

    public function delete($id)
    {
        $this->member->model()->where('id', $id)->delete();
        return $this->success();
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
