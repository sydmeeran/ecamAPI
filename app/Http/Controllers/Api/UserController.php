<?php

namespace App\Http\Controllers\Api;

use App\Repositories\DataRepo;
use App\Role;
use App\User;
use Arga\Utils\ActionMiddlewareTrait;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends BaseController
{
    use ActionMiddlewareTrait;

    protected $user;

    public function __construct()
    {
        $this->actionMiddleware([
            'store' => 'user-create',
            'pagination' => 'user-retrieve',
            'get' => 'user-retrieve',
            'search' => 'user-retrieve',
            'delete' => 'user-delete',
            'active_deactive' => 'user-deactive',
            'update' => 'user-update',
//            'update_profile' => 'user-retrieve'
        ]);

        $this->user = DataRepo::user();
    }

    public function store(Request $request)
    {
            return $this->user->store($request);
    }

    public function auth_user()
    {
            $user = Auth::user()->toArray();
            $role = Role::where('id', $user['role_id'])->with('permissions')->get(['id', 'role'])->toArray();
            $user['role'] = $role[0];
            return $this->response($user);
    }

    public function getAll()
    {
            $user = User::with('role')->get()->toArray();
            return $this->response($user);

    }

    public function pagination()
    {
            $user = User::paginate(20);
            return $this->response($user);
    }

    public function get($id)
    {
            $user = User::where('id', $id)->get()->toArray();
            if (empty($user)) {
                return $this->empty_data();
            }
            $user = $user[0];
            $role = Role::where('id', $user['role_id'])->with('permissions')->get()->toArray();
            if (empty($role)) {
                return $this->empty_data();
            }
            $user['role'] = $role[0];
            return $this->response($user);
    }

    public function search(Request $request)
    {
            $keyword = $request->get('keyword');
            $result = User::where('name', 'LIKE', '%' . $keyword . '%')
                ->orWhere('email', 'LIKE', '%' . $keyword . '%')
                ->get()->toArray();

            return $this->response($result);
    }

    public function delete($id)
    {
            User::where('id', $id)->delete();
            return response()->json($this->success);
    }

    public function update(Request $request, $id)
    {
        return $this->user->update($request, $id);
    }

    public function update_profile(Request $request, $id)
    {
            return $this->user->update_profile($request, $id);
    }

    public function update_password(Request $request, $id)
    {
            return $this->user->update_password($request, $id);
    }

    public function active_deactive(Request $request, $id)
    {
            User::where('id', $id)->update([
                'is_active' => $request->get('status')
            ]);
            return response()->json($this->success);
    }
}
