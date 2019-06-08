<?php

use Faker\Generator as Faker;
use App\Models\TelephoneNumber;

$factory->define(TelephoneNumber::class, function (Faker $faker) {
    return [
        'number' => $faker->tollFreePhoneNumber,
        'member_id'  => function(){
        	return random_int(
        			DB::table('members')->min('id'), 
        			DB::table('members')->max('id')
        		);
        }
    ];
});
