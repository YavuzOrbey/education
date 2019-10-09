<?php

use Illuminate\Support\Str;
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
    $groups = App\Group::pluck('id')->toArray();
    return [
        'first_name' => $faker->firstName,
        'last_name' =>$faker->lastName,
        'email' => $faker->unique()->safeEmail,
        'email_verified_at' => now(),
        'password' => $faker->password, // secret
        'group_id' => $faker->randomElement($groups),
        'remember_token' => Str::random(10),
    ];
});
