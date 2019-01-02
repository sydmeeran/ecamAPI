<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\RoleDeleteException;
use App\Repositories\DataRepo;
use Arga\Utils\ActionMiddlewareTrait;
use Illuminate\Http\Request;

class RoleController extends BaseController
{
    use ActionMiddlewareTrait;

    protected $role, $user;

    public function __construct()
    {
        $this->role = DataRepo::role();
        $this->user = DataRepo::user();

        $this->actionMiddleware([
            'index' => 'role-retrieve',
            'store' => 'role-create',
            'update' => 'role-update',
            'get' => 'role-retrieve',
            'delete' => 'role-delete'
        ]);
    }

    public function index(Request $request)
    {
        if ($this->check_api_key($request)) {
            $roles = $this->role->model()->where('id', '!=', 1)->with('permissions')->get()->toArray();
            return $this->response($roles);
        }
        return $this->unauthorized();
    }

    public function store(Request $request)
    {
        if ($this->check_api_key($request)) {
            $this->role->store($request);
            return response()->json($this->success);
        }
        return $this->unauthorized();
    }

    public function update(Request $request, $id)
    {
        if ($this->check_api_key($request)) {
            $this->role->update($request, $id);
            return response()->json($this->success);
        }
        return $this->unauthorized();
    }

    public function getAll(Request $request)
    {
        if ($this->check_api_key($request)) {
            $roles = $this->role->model()->where('id', '!=', 1)->with('permissions')->get()->toArray();
            return $this->response($roles);
        }
        return $this->unauthorized();
    }

    public function get(Request $request, $id)
    {
        if ($this->check_api_key($request)) {
            $role = $this->role->with(['permissions'], $id)->toArray();
            if (empty($role)) {
                return $this->empty_data();
            }
            return $this->response($role[0]);
        }

        return $this->unauthorized();
    }

    public function delete(Request $request, $id)
    {
        if ($this->check_api_key($request)) {
            if ($this->user->model()->where('role_id', $id)->exists()) {
                throw new RoleDeleteException();
            }
            $this->role->model()->where('id', $id)->delete();
            return response()->json($this->success);
        }
        return $this->unauthorized();
    }
}
