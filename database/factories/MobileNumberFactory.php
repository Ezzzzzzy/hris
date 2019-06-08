<?php

use Faker\Generator as Faker;
use App\Models\MobileNumber;

$factory->define(MobileNumber::class, function (Faker $faker) {
    return [
        'number' => $faker->phoneNumber,
        'member_id' => function(){
        	return random_int(
        			DB::table('members')->min('id'), 
	        		DB::table('members')->max('id')
	        	);
        },
    ];
});
