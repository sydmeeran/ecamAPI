<?php
/**
 * Created by PhpStorm.
 * User: naingminkhant
 * Date: 8/3/18
 * Time: 3:44 PM
 */

namespace Arga\Storage\Database\Contracts;

use Illuminate\Database\Eloquent\Builder;

interface QueryFilter
{
    public function apply(Builder $query): Builder;
}
