<?php
/**
 * Created by PhpStorm.
 * User: naingminkhant
 * Date: 12/20/18
 * Time: 11:49 AM
 */

namespace Arga\Accountant;

use Arga\Accountant\User\UserRepository;

class DataRepo
{
    public static function user(): UserRepository
    {
        return app(UserRepository::class);
    }

}
