<?php

use App\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => "Super Admin",
            'email' => "superadmin@gmail.com",
            'password' => bcrypt('password'),
            'role_id' => 1
        ]);
    }
}
