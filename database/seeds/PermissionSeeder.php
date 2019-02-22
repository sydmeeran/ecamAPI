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
        // $permission = ['create', 'retrieve', 'update', 'delete'];

        // Permission::create([
        //     'permission' => 'all'
        // ]);

        // foreach($permission as $p){
        //     Permission::create([
        //         'permission' => 'role-'.$p
        //     ]);
        // }

        // foreach($permission as $p){
        //     Permission::create([
        //         'permission' => 'user-'.$p
        //     ]);
        // }

        // Permission::create([
        //     'permission' => 'user-deactive'
        // ]);

        // foreach($permission as $p){
        //     Permission::create([
        //         'permission' => 'customer-'.$p
        //     ]);
        // }

        // Permission::create([
        //     'permission' => 'customer-deactive'
        // ]);

        // Permission::create([
        //     'permission' => 'customer-suspend'
        // ]);

        // foreach($permission as $p){
        //     Permission::create([
        //         'permission' => 'job-entry-'.$p
        //     ]);
        // }

        // foreach($permission as $p){
        //     Permission::create([
        //         'permission' => 'quotation-'.$p
        //     ]);
        // }

        Permission::create([
                'permission' => 'quotation-cancel'
            ]);

        // Permission::create([
        //     'permission' => 'invoice-retrieve'
        // ]);
        // Permission::create([
        //     'permission' => 'invoice-create'
        // ]);
        // Permission::create([
        //     'permission' => 'invoice-delete'
        // ]);

        // Permission::create([
        //     'permission' => 'receipt-retrieve'
        // ]);
        // Permission::create([
        //     'permission' => 'receipt-create'
        // ]);
        // Permission::create([
        //     'permission' => 'receipt-delete'
        // ]);

        // Permission::create([
        //     'permission' => 'schedule-delete'
        // ]);

        // Permission::create([
        //     'permission' => 'revenue-retrieve'
        // ]);

    }
}
