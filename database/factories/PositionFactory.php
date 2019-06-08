<?php

use Faker\Generator as Faker;
use App\Models\Position;

$factory->define(Position::class, function (Faker $faker) {
    static $order = 0;
    
    return [
        'position_name' => $faker->unique()->jobTitle,
        'enabled' => 1,
        'order' => ++$order,
        'last_modified_by'  => "Admin",
    ];
});
