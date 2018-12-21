<?php

use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(App\User::class, function (Faker $faker) {
    return [
        'name'          => $faker->name,
        'email'         => $faker->safeEmail,
        'position'      => "Super Admin",
        'nrc_no'        => '9/AMaZa(N)839282',
        'nrc_photo'     => 'db/nrc_photos/default.jpg',
        'phone_no'      => '0923832323',
        'address'       => 'no.12, 23rd street, Yangon',
        'password'      => bcrypt('password'),
        'role_id'       => 1,
        'profile_photo' => 'db/profile_photos/default.jpg',
    ];
});
