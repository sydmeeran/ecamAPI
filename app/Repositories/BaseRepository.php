<?php

namespace App\Repositories;

use App\UUID;

abstract class BaseRepository
{
    abstract public function model();

    protected function uuid($prefix, $length = 8)
    {
        $uuid = new UUID($prefix);

        return $uuid->limit($length)->uuid;
    }

    public function getAll()
    {
        // dd($this->model()->get()->all());
        return $this->model()->get()->all();
    }

    public function find($id)
    {
        return $this->model()->find($id);
    }

    public function count()
    {
        return $this->model()->count();
    }

    public function paginate($paginate)
    {
        return $this->model()->paginate($paginate);
    }

    public function with(array $with, $id = null)
    {
        if (is_null($id)) {
            return $this->model()->with($with)->get();
        }

        return $this->model()->with($with)->where('id', $id)->get();
    }

    public function delete($id)
    {
        /**
         * @todo find or findOrFail
         */
        $this->model()->where('id', $id)->delete();
    }
}
