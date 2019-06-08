<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Role::class, function (Faker $faker) {
    return [
        'name' => $faker->firstName,
        'guard_name' => 'web',
        'description' => $faker->sentence(),
        'status' => $faker->boolean(50) ? 0 : 1,
        'status_color' => $faker->hexcolor,
    ];
});
