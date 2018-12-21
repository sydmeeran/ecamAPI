<?php
/**
 * Created by PhpStorm.
 * User: naingminkhant
 * Date: 12/20/18
 * Time: 11:45 AM
 */

namespace Arga\Accountant\User;

use App\User;
use Arga\Storage\Database\QueryFilterTrait;
use Arga\Storage\Database\Repository;

class UserRepository extends Repository
{
    use QueryFilterTrait;

    /**
     * @return \Illuminate\Database\Query\Builder
     */
    protected function model()
    {
        return $this->applyQueryFilter(User::query());
    }

    protected function validateData(array $data, $id = null): ?array
    {
        return $data;
    }
}
