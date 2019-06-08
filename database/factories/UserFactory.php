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

    $name = $faker->firstName;

    return [
        'name' => $name,
        'email' => $faker->unique()->safeEmail,
        'password' => Hash::make($name),
        'is_verified' => 1,
        'remember_token' => str_random(10),
    ];
});