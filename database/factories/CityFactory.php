<?php

use Faker\Generator as Faker;
use App\Models\City;

$factory->define(City::class, function (Faker $faker) {
    return [
        'city_name' => $faker->unique()->city,
        'enabled' => 1,
        'last_modified_by' => "Admin",
        'region_id' => function () {
            return random_int(
                    DB::table('regions')->min('id'),
                    DB::table('regions')->max('id')
                );
        },
    ];
});
