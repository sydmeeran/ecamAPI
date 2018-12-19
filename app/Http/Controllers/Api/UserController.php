<?php

namespace App\Http\Controllers\Api;

use App\Repositories\DataRepo;
use Arga\Utils\ActionMiddlewareTrait;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    use ActionMiddlewareTrait;

    protected $repo;

    public function __construct()
    {
        $this->repo = DataRepo::user();

        $this->actionMiddleware([
            'index'      => 'permission:user-retrieve',
            'create'     => 'permission:user-create',
            'edit'       => 'permission:user-retrieve',
            'store'      => 'permission:user-update',
            'update'     => 'permission:user-update',
            'destroy'    => 'permission:user-delete',
            'deactivate' => 'permission:user-deactive',
        ]);
    }

    public function index()
    {
        $users = $this->repo->getAll();

        return $users;
    }

    public function create()
    {
        return ok();
    }
}
