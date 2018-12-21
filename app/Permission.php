<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    protected $table = 'permissions';

    protected $fillable = [
        'permission',
    ];

    const ALL_PERMISSION = 'all';
    const USER_CREATE = 'user-create';
    const USER_RETRIEVE = 'user-retrieve';
    const USER_UPDATE = 'user-update';
    const USER_DELETE = 'user-delete';
    const USER_DEACTIVATE = 'user-deactive'; // Should user-deactivate

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_permissions');
    }
}
