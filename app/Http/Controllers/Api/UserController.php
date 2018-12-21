<?php

namespace App\Http\Controllers\Api;

use App\Permission;
use Arga\Accountant\DataRepo;
use Arga\Utils\ActionMiddlewareTrait;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{
    use ActionMiddlewareTrait;

    protected $repo;

    public function __construct()
    {
        $this->repo = DataRepo::user();

        $this->actionMiddleware([
            'index'      => Permission::USER_RETRIEVE,
            'create'     => Permission::USER_CREATE,
            'edit'       => Permission::USER_UPDATE,
            'store'      => Permission::USER_CREATE,
            'update'     => Permission::USER_UPDATE,
            'destroy'    => Permission::USER_DELETE,
            'deactivate' => Permission::USER_DEACTIVATE,
        ]);
    }

    public function index(Request $request)
    {
        $paginate = $request->get('paginate');
        if ($paginate) {
            return $this->repo->paginate();
        }

        return $this->repo->get();
    }

    public function create()
    {
        return ok();
    }

    public function destroy($id)
    {
        $this->repo->destroy($id);

        return ok();
    }

    public function show($id)
    {
        return $this->repo->find($id);
    }
}
