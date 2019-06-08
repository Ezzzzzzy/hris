<?php

use Faker\Generator as Faker;
use App\Models\AddressCity;

$factory->define(AddressCity::class, function (Faker $faker) {
    return [ 'address_city_name' => $faker->city() ];
});
