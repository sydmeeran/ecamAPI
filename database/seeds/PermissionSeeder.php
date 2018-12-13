<?php

use App\Permission;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permission = ['create', 'retrieve', 'update', 'delete'];

//        Permission::create([
//            'permission' => 'all'
//        ]);
//
//        foreach($permission as $p){
//            Permission::create([
//                'permission' => 'role-'.$p
//            ]);
//        }
//
//        foreach($permission as $p){
//            Permission::create([
//                'permission' => 'user-'.$p
//            ]);
//        }
//
//        Permission::create([
//            'permission' => 'user-deactive'
//        ]);
//
//        foreach($permission as $p){
//            Permission::create([
//                'permission' => 'customer-'.$p
//            ]);
//        }
//
//        Permission::create([
//            'permission' => 'customer-deactive'
//        ]);
//
//        Permission::create([
//            'permission' => 'customer-suspend'
//        ]);

        foreach($permission as $p){
            Permission::create([
                'permission' => 'job-entry-'.$p
            ]);
        }
    }
}
