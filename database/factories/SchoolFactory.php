<?php

use Faker\Generator as Faker;
use App\Models\School;

$factory->define(School::class, function (Faker $faker) {
	$school_type = [
		'Tertiary',
		'Elementary',
		'High School',
	];

    return [
        'school_name' => 'University of the ' . $faker->city . ' - ' . $faker->state,
		'school_type' => $school_type[rand(0, 2)],
		'started_at'  => $faker->dateTimeBetween('-15 years', '-4years'),
		'ended_at'    => $faker->dateTimeBetween('-4 years', 'now'),
		'degree'	  => ($school_type[rand(0, 2)] != 'Tertiary') 
						 ? ' ' 
						 : 'Bachelor of Science in ' . $faker->word,
		'member_id'	  => function(){
			return random_int(
				DB::table('members')->min('id'), 
				DB::table('members')->max('id')
			);
		},
    ];
});
