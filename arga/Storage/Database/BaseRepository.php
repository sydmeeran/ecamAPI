<?php

namespace Arga\Storage\Database;

use Arga\Auth\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use League\Fractal\TransformerAbstract;

/**
 * Class BaseRepository
 *
 * @package Arga\Stroage\Database
 * @property $transformer
 */
abstract class BaseRepository
{
    /**
     * @return Builder
     */
    abstract protected function model(): Builder;

    abstract protected function validateData(array $data, $id = null): ?array;

    public function getUserId()
    {
        $user = auth()->user();
        if ($user instanceof User) {
            $user = $user->getId();
        }

        return $user;
    }

    /**
     * @return User
     */
    public function user()
    {
        return auth()->user();
    }

    public function getUser()
    {
        return $this->item($this->user());
    }

    /**
     * @param $data
     * @param $rules
     * @return bool
     * @throws \Illuminate\Validation\ValidationException
     */
    public function validate($data, $rules): bool
    {
        $validate = Validator::make($data, $rules);

        if ($validate->fails()) {
            throw new ValidationException($validate);
        }

        return true;
    }

    public function setTransformer(TransformerAbstract $transformerAbstract)
    {
        $this->transformer = $transformerAbstract;

        return $this;
    }

    /**
     * @param $id
     * @return array
     * @throws \Exception
     */
    public function destroy($id)
    {
        $status = $this->model()->findOrFail($id)->delete();

        return ['status' => $status];
    }

    /**
     * @param $id
     * @return array
     */
    public function permanentDestroy($id)
    {
        $status = $this->model()->withTrashed()->findOrFail($id)->forceDelete();

        return ['status' => $status];
    }

    /**
     * @param $id
     * @return array
     */
    public function recovery($id)
    {
        $status = $this->model()->withTrashed()->find($id)->restore();

        return ['success' => $status];
    }

    /**
     * @param $id
     * @param bool $transform
     * @return mixed
     */
    public function find($id, $transform = true)
    {
        $data = $this->model()->findOrFail($id);

        return $transform ?
            $this->item($data) :
            $data;
    }

    /**
     * @param $column
     * @param $value
     * @param string $operator
     * @param bool $transform
     * @return mixed
     */
    public function findByColumn($column, $value, $operator = "=", $transform = true)
    {
        $data = $this->model()->where($column, $operator, $value)->first();

        return $transform ?
            $this->item($data) : $data;
    }

    public function item($data)
    {
        return $this->transform($data)['data'];
    }

    /**
     * @return TransformerAbstract
     */
    protected function getTransformer()
    {
        return $this->transformer;
    }

    public function transform($data, TransformerAbstract $transformer = null)
    {
        $transformer = $transformer ?? $this->getTransformer();

        return fractal($data, $transformer)->toArray();
    }

    public function collection($data)
    {
        $data = $this->transform($data);

        $paginate = array_get($data, 'meta.pagination');

        if ($paginate) {
            $data['meta']['pagination']['start_index'] =
                (($paginate['current_page'] - 1) * $paginate['per_page']) + 1;

            return $data;
        }

        return $data['data'];
    }

    /**
     * @return \Arga\Auth\Admin
     */
    public function sysAdmin()
    {
        return auth('admin')->user();
    }

    public function get()
    {
        $datas = $this->model()->get();

        return $this->collection($datas);
    }

    public function paginate()
    {
        $datas = $this->model()->paginate();

        return $this->collection($datas);
    }
}
