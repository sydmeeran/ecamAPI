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

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_permissions');
    }
}
