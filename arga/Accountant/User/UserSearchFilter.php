<?php
/**
 * Created by PhpStorm.
 * User: naingminkhant
 * Date: 12/20/18
 * Time: 2:06 PM
 */

namespace Arga\Accountant\User;

use Arga\Storage\Database\Contracts\QueryFilter;
use Illuminate\Database\Eloquent\Builder;

class UserSearchFilter implements QueryFilter
{
    public function apply(Builder $query): Builder
    {
        // TODO: Implement apply() method.
    }
}
