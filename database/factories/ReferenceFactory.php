<?php

use Faker\Generator as Faker;
use App\Models\Reference;

$factory->define(Reference::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
		'address' 	 	 => $faker->address,
		'company' 	 	 => $faker->company,
		'position' 	 	 => $faker->jobTitle,
		'contact' 	 	 => $faker->phoneNumber,
		'member_id'  	 => function(){
			return random_int(DB::table('members')->min('id'), DB::table('members')->max('id'));
		},
    ];
});
