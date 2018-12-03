<?php

use App\RolePermission;
use Illuminate\Database\Seeder;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        RolePermission::create([
            'role_id' => 1,
            'permission_id' => 1
        ]);
    }
}
