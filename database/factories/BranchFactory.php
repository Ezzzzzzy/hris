<?php

use Faker\Generator as Faker;
use App\Models\Branch;

$factory->define(Branch::class, function (Faker $faker) {
    $brands = [
        'Dell',
        'Jollibee',
        'Mang Inasal',
        'Taitech Marine',
    ];

    return [
        'branch_name' => $brands[rand(0, count($brands)-1)] . " - " . $faker->streetName,
        'enabled' => 1,
        'brand_id' => App\Models\Brand::all()->random()->id,
        'location_id' => App\Models\Location::all()->random()->id
    ];
});
