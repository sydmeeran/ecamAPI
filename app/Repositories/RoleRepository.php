<?php
/**
 * Created by PhpStorm.
 * User: damon
 * Date: 1/1/19
 * Time: 9:40 PM
 */

namespace App\Repositories;


use App\Role;
use App\RolePermission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class RoleRepository extends BaseRepository
{
    public function model()
    {
        return Role::query();
    }

    public function validation($data)
    {
        return Validator::make($data, [
            'role' => 'required|max:30|unique:roles',
            'permissions' => 'required'
        ]);
    }

    public function setData(Request $request)
    {
        return [
            'role' => $request->get('role'),
            'permissions' => $request->get('permissions')
        ];
    }

    public function store(Request $request)
    {
        $data = $this->setData($request);

        $validator = $this->validation($data);

        if ($validator->fails()) {
            return new ValidationException();
        }

        $role = $this->model()->create([
            'role' => $data['role']
        ]);

        foreach ($data['permissions'] as $permission_id) {
            RolePermission::create([
                'role_id' => $role->id,
                'permission_id' => $permission_id
            ]);
        }
    }

    public function updateValidation($data){
        if ($this->model()->where('role', $data['role'])->exists()) {
            return Validator::make($data, [
                'role' => 'required|max:30',
                'permissions' => 'required'
            ]);
        }
        return $this->validation($data);
    }

    public function update(Request $request, $id){

        $data = $this->setData($request);
        $validator = $this->updateValidation($data);

        if ($validator->fails()) {
            return new ValidationException();
        }

        $this->model()->where('id', $id)->update([
            'role' => $data['role']
        ]);

        RolePermission::where('role_id', $id)->delete();

        foreach ($data['permissions'] as $permission_id) {
            RolePermission::create([
                'role_id' => $id,
                'permission_id' => $permission_id
            ]);
        }
    }
}