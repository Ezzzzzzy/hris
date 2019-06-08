<?php

use Faker\Generator as Faker;
use App\Models\FamilyMember;

$factory->define(FamilyMember::class, function (Faker $faker) {
	$family_type = [
		'Son',
		'Mother',
		'Father',
		'Daughter',
		'Grandmother',
		'Grandfather',
	];

    return [
        'family_type' 		 => $family_type[rand(0, count($family_type)-1)],
		'name' => $faker->name,
		'age'		  		 => $faker->numberBetween(15, 55),
		'occupation'  	 	 => $faker->jobTitle,
		'member_id'   		 => function(){
			return random_int(
					DB::table('members')->min('id'), 
					DB::table('members')->max('id')
				);
		},
    ];
});
