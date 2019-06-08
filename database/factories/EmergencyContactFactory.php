<?php

use Faker\Generator as Faker;
use App\Models\EmergencyContact;

$factory->define(EmergencyContact::class, function (Faker $faker) {
	$family_type = [
		'Son',
        'Mother',
        'Father',
        'Daughter',
        'Grandfather',
        'Grandmother',
	];

    return [
        'name' => $faker->name,
        'relationship'           => $family_type[rand(0, count($family_type)-1)],
        'address'                => $faker->address,
        'contact'                => $faker->phoneNumber,
        'member_id'              => function(){
        	return random_int(
                    DB::table('members')->min('id'), 
                    DB::table('members')->max('id')
                );
        },
    ];
});
