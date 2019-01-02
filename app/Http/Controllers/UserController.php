<?php
//
//namespace App\Http\Controllers;
//
//use App\Repositories\DataRepo;
//use App\Role;
//use App\User;
//use Arga\Utils\ActionMiddlewareTrait;
//use Illuminate\Auth\AuthenticationException;
//use Illuminate\Http\Request;
//use Illuminate\Support\Facades\Auth;
//use Illuminate\Support\Facades\Input;
//use Illuminate\Support\Facades\Validator;
//use Illuminate\Validation\UnauthorizedException;
//use Illuminate\Validation\ValidationException;
//
//class UserController extends BaseController
//{
////    use ActionMiddlewareTrait;
////
////    protected $user;
////
////    public function __construct()
////    {
////        $this->user = DataRepo::user();
////
////        $this->actionMiddleware([
////            'register' => 'user-create',
////            'getAll_pagination' => 'user-retrieve',
////            'get' => 'user-retrieve',
////            'search' => 'user-retrieve',
////            'delete' => 'user-delete',
////            'active_deactive' => 'user-deactive'
////        ]);
////    }
////
////    /**
////     * @return \Illuminate\Http\JsonResponse
////     * @throws AuthenticationException
////     */
////    public function login()
////    {
////        if (Auth::attempt(['email' => request('email'), 'password' => request('password')])) {
////            $user = Auth::user();
////            $user_arr = $user->toArray();
////            $role = Role::where('id', $user_arr['role_id'])->with('permissions')->get(['id', 'role'])->toArray();
////            $user_arr['role'] = $role[0];
////            $success['user'] = $user_arr;
////            $success['token'] = $user->createToken('api-user')->accessToken;
////            return $this->success_login_response($success);
////        } else {
////            return $this->unauthenticated();
////        }
////    }
////
////    public function register(Request $request)
////    {
////        if ($this->check_api_key($request)) {
////            return $this->user->store($request);
////        }
////        return $this->unauthorized();
////    }
////
////    public function logout(Request $request)
////    {
////        if ($this->check_api_key($request)) {
////
////            $request->user()->token()->delete();
////
////            return $this->success();
////        }
////        return $this->unauthorized();
////    }
////
////    public function auth_user(Request $request)
////    {
////        if ($this->check_api_key($request)) {
////            $user = Auth::user()->toArray();
////            $role = Role::where('id', $user['role_id'])->with('permissions')->get(['id', 'role'])->toArray();
////            $user['role'] = $role[0];
////            return $this->response($user);
////        }
////        return $this->unauthorized();
////    }
////
////    public function getAll(Request $request)
////    {
////        if ($this->check_api_key($request)) {
////            $user = User::with('role')->get()->toArray();
////            return $this->response($user);
////        }
////        return $this->unauthorized();
////    }
////
////    public function getAll_pagination(Request $request)
////    {
////        if ($this->check_api_key($request)) {
////            $user = User::paginate(20);
////            return $this->response($user);
////        }
////        return $this->unauthorized();
////    }
////
////    public function get(Request $request, $id)
////    {
////        if ($this->check_api_key($request)) {
////            $user = User::where('id', $id)->get()->toArray();
////            if (empty($user)) {
////                return $this->empty_data();
////            }
////            $user = $user[0];
////            $role = Role::where('id', $user['role_id'])->with('permissions')->get()->toArray();
////            if (empty($role)) {
////                return $this->empty_data();
////            }
////            $user['role'] = $role[0];
////            return $this->response($user);
////        }
////        return $this->unauthorized();
////    }
////
////    public function search(Request $request)
////    {
////        if ($this->check_api_key($request)) {
////            $keyword = $request->get('keyword');
////            $result = User::where('name', 'LIKE', '%' . $keyword . '%')
////                ->orWhere('email', 'LIKE', '%' . $keyword . '%')
////                ->get()->toArray();
////
////            return $this->response($result);
////        }
////        return $this->unauthorized();
////    }
////
////    public function delete(Request $request, $id)
////    {
////        if ($this->check_api_key($request)) {
////            User::where('id', $id)->delete();
////            return response()->json($this->success);
////        }
////        return $this->unauthorized();
////    }
////
////    public function update_profile(Request $request, $id)
////    {
////        if ($this->check_api_key($request)) {
////            return $this->user->update_profile($request, $id);
////        }
////        return $this->unauthorized();
////    }
////
////    public function update_password(Request $request, $id)
////    {
////        if ($this->check_api_key($request)) {
////            return $this->user->update_password($request, $id);
////        }
////        return $this->unauthorized();
////    }
////
////    public function active_deactive(Request $request, $id)
////    {
////        if ($this->check_api_key($request)) {
////            User::where('id', $id)->update([
////                'is_active' => $request->get('status')
////            ]);
////            return response()->json($this->success);
////        }
////        return $this->unauthorized();
////    }
//
//}
