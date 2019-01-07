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

    public function __construct(Request $request)
    {
        $this->check_api_key($request);

        $this->actionMiddleware([
            'index' => 'role-retrieve',
            'store' => 'role-create',
            'update' => 'role-update',
            'get' => 'role-retrieve',
            'delete' => 'role-delete'
        ]);

        $this->role = DataRepo::role();
        $this->user = DataRepo::user();
    }

    public function index()
    {
        $roles = $this->role->model()->where('id', '!=', 1)->with('permissions')->get()->toArray();
        return $this->response($roles);
    }

    public function store(Request $request)
    {
        $this->role->store($request);
        return response()->json($this->success);
    }

    public function update(Request $request, $id)
    {
        $this->role->update($request, $id);
        return response()->json($this->success);
    }

    public function getAll()
    {
        $roles = $this->role->model()->where('id', '!=', 1)->with('permissions')->get()->toArray();
        return $this->response($roles);
    }

    public function get($id)
    {
        $role = $this->role->with(['permissions'], $id)->toArray();
        if (empty($role)) {
            return $this->empty_data();
        }
        return $this->response($role[0]);
    }

    public function delete($id)
    {
        if ($this->user->model()->where('role_id', $id)->exists()) {
            throw new RoleDeleteException();
        }
        $this->role->model()->where('id', $id)->delete();
        return response()->json($this->success);
    }
}
