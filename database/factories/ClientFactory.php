<?php

use Faker\Generator as Faker;
use App\Models\Client;

$factory->define(Client::class, function (Faker $faker) {
    $company = $faker->company;

    $last_modified_by = [
        'Ezra Paz',
        'Neil Nato',
        'Rachelle Uy',
        'Nards Paragas',
        'Jethru Aleria',
        'Jerome Agapay',
        'Patriz Malabanan',
    ];

    $words = explode(" ", $company);
    $code = "";

    foreach ($words as $w) {
        $code .= $w[0];
    }

    return [
        'client_name' => ucfirst($company),
        'code' => $code,
        'enabled' => 1,
        'last_modified_by' => $last_modified_by[random_int(0, count($last_modified_by)-1)]
    ];
});
