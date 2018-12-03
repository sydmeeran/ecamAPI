<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $table = 'roles';

    protected $fillable = [
        'role'
    ];

    public function permissions(){
        return $this->belongsToMany(Permission::class, 'role_permissions');
    }

    public function users(){
        return $this->hasMany(User::class);
    }
}
