<?php
/**
 * Created by PhpStorm.
 * User: naingminkhant
 * Date: 12/19/18
 * Time: 1:50 PM
 */

namespace Arga\Utils;

use Symfony\Component\HttpKernel\Exception\HttpException;

class PermissionException extends HttpException
{
    private $requiredRoles = [];

    private $requiredPermissions = [];

    public static function forRoles(array $roles): self
    {
        $message = 'User does not have the right roles.';

        if (config('permission.display_permission_in_exception')) {
            $permStr = implode(', ', $roles);
            $message = 'User does not have the right roles. Necessary roles are '.$permStr;
        }

        $exception = new static(403, $message, null, []);
        $exception->requiredRoles = $roles;

        return $exception;
    }

    public static function forPermissions(array $permissions): self
    {
        $permStr = implode(', ', $permissions);
        $message = 'User does not have the right permissions. Necessary permissions are '.$permStr;

        $exception = new static(403, $message, null, []);
        $exception->requiredPermissions = $permissions;

        return $exception;
    }

    public static function notLoggedIn(): self
    {
        return new static(403, 'User is not logged in.', null, []);
    }

    public function getRequiredRoles(): array
    {
        return $this->requiredRoles;
    }

    public function getRequiredPermissions(): array
    {
        return $this->requiredPermissions;
    }
}
