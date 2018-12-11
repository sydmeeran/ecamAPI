<?php
/**
 * Created by PhpStorm.
 * User: naingminkhant
 * Date: 8/3/18
 * Time: 3:48 PM
 */

namespace Arga\Storage\Database;

use Arga\Storage\Database\Contracts\QueryFilter;
use Illuminate\Database\Eloquent\Builder;

trait QueryFilterTrait
{
    /**
     * @var array|\Arga\Storage\Database\Contracts\QueryFilter[]
     */
    protected $localQueryFilters = [];

    protected $skipQueryFilter = false;

    public function pushQueryFilter(QueryFilter $filter, $key = null): self
    {
        $key = $key ?? \get_class($filter);
        $this->localQueryFilters[$key] = $filter;

        return $this;
    }

    public function skipQueryFilter($skip = true): self
    {
        $this->skipQueryFilter = $skip;

        return $this;
    }

    public function applyQueryFilter(Builder $query): Builder
    {
        if ($this->skipQueryFilter) {
            return $query;
        }

        foreach ($this->localQueryFilters as $key => $filter) {
            $query = $filter->apply($query);
        }

        return $query;
    }
}
