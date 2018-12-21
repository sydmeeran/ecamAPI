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
//        factory(User::class, 100)->create();
        User::create([
            'name' => "Toe Tet",
            'email' => "superadmin@gmail.com",
            'position' => "Super Admin",
            'nrc_no' => '9/AMaZa(N)839282',
            'nrc_photo' => 'db/nrc_photos/default.jpg',
            'phone_no' => '0923832323',
            'address' => 'no.12, 23rd street, Yangon',
            'password' => bcrypt('password'),
            'role_id' => 1,
            'profile_photo' => 'db/profile_photos/default.jpg'
        ]);

        User::create([
            'name' => "Toe Tet",
            'email' => "admin@gmail.com",
            'position' => "Admin",
            'nrc_no' => '9/AMaZa(N)839282',
            'nrc_photo' => 'db/nrc_photos/default.jpg',
            'phone_no' => '0923832323',
            'address' => 'no.12, 23rd street, Yangon',
            'password' => bcrypt('password'),
            'role_id' => 1,
            'profile_photo' => 'db/profile_photos/default.jpg'
        ]);
    }
}
