<?php

namespace App\Http\Middleware;

use App\Permission;
use Arga\Utils\PermissionException;
use Closure;

class PermissionMiddleware
{
    /**
     * @param $request
     * @param \Closure $next
     * @param $permission
     * @return mixed
     */
    public function handle($request, Closure $next, $permission)
    {
        if (app('auth')->guest()) {
            throw PermissionException::notLoggedIn();
        }

        /** @var \App\User $user */
        $user = app('auth')->user();
        if ($user->isPermission($permission) || $user->isPermission(Permission::ALL_PERMISSION)) {
            return $next($request);
        }

        throw PermissionException::forPermissions([
            $permission,
        ]);
    }
}
