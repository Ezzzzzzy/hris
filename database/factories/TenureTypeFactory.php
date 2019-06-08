<?php

use Faker\Generator as Faker;
use App\Models\TenureType;

$factory->define(TenureType::class, function (Faker $faker) {
    static $order = 0;

    $tenure_types = [
        ['0 mos - 1 year', 0, 12],
        ['1 year - 2 years', 13, 24],
        ['2 years - 3 years', 25, 36],
        ['3 years and up', 36, 48],
    ];

    return [
        'enabled' => 1,
        'tenure_type' => $tenure_types[$order][0],
        'month_start_range' => $tenure_types[$order][1],
        'month_end_range'   => $tenure_types[$order++][2],
    ];
});
