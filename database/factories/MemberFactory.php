<?php

use Faker\Generator as Faker;
use App\Models\Member;

$factory->define(Member::class, function (Faker $faker) {
    static $new_member_id = 0;

    $address = $faker->address;
    $email = $faker->unique()->safeEmail;
    $gender = ['M','F'];
    $name = $faker->firstName;

    $marital_status = [
        'Single',
        'Married',
        'Widowed',
        'Separated',
    ];
    
    $last_modified_by = [
        'Ezra Paz',
        'Neil Nato',
        'Rachelle Uy',
        'Jerome Agapay',
        'Nards Paragas',
        'Jethru Aleria',
        'Patriz Malabanan',
    ];

    return [
        'existing_member_id' => $faker->numerify('####'),
        'new_member_id' => ++$new_member_id,
        'nickname' => $name,
        'last_name' => $faker->lastName,
        'first_name' => $name,
        'middle_name' => $faker->firstName,
        'extension_name' => $faker->optional()->suffix,
        'present_address' => $address,
        'permanent_address' => $address,
        'height' => $faker->numberBetween(50, 200),
        'weight' => $faker->numberBetween(50, 200),
        'tin' => $faker->numerify('############'),
        'sss_num' => $faker->numerify('##########'),
        'philhealth_num' => $faker->numerify('########'),
        'pag_ibig_num' => $faker->numerify('############'),
        'fb_address' => $email,
        'email_address' => $email,
        'civil_status' => $marital_status[rand(0, count($marital_status)-1)],
        'gender' => $gender[rand(0, 1)],
        'birthdate' => $faker->date('YYYY-MM-DD', '2000-12-31'),
        'birthplace' => $faker->address,
        'enabled' => $faker->numberBetween(0, 1),
        'data_completion' => $faker->numberBetween(0, 1),
        'last_modified_by' => $last_modified_by[rand(0, count($last_modified_by)-1)],
        'present_address_city' => $faker->city,
        'permanent_address_city' => $faker->city,
    ];
});
