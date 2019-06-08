<?php

use Faker\Generator as Faker;
use App\Models\Report;

$factory->define(Report::class, function (Faker $faker) {
    return [
        'title' => $faker->word,
        'type' => $faker->boolean(50) ? 'HC' : 'MI',
        'levels' => '',
        'template_no' => $faker->randomDigitNotNull,
        'saved' => $faker->boolean(50) ? 1 : 0,
        'generated_by' => function () {
            return random_int(
                \DB::table('users')->min('id'),
                \DB::table('users')->max('id')
            );
        },
    ];
});
