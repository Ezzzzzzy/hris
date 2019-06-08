<?php

use Faker\Generator as Faker;
use App\Models\Location;

$factory->define(Location::class, function (Faker $faker) {
    return [
        'location_name' => $faker->state . " " . $faker->streetName,
        'enabled' => 1,
        'last_modified_by' => "Admin",
        'city_id' => function () {
            return random_int(
                DB::table('cities')->min('id'),
                DB::table('cities')->max('id')
            );
        },
    ];
});
