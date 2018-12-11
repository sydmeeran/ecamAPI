<?php
/**
 * Created by PhpStorm.
 * User: damon
 * Date: 12/11/18
 * Time: 11:31 AM
 */

namespace App\Repositories;


class DataRepo
{
    public static function customer(): CustomerRepository
    {
        return app(CustomerRepository::class);
    }

    public static function business(): BusinessRepostitory
    {
        return app(BusinessRepostitory::class);
    }
}