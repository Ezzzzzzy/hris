<?php

use Faker\Generator as Faker;
use App\Models\{EmploymentHistory, Client, Reason, Position};

$factory->define(EmploymentHistory::class, function (Faker $faker) {
    return [
		'started_at'   		 => $faker->date('2000-01-01') . " " . $faker->time('H:i:s', 'now'),
		'ended_at' 	   		 => $faker->date('2000-01-01') . " " . $faker->time('H:i:s', 'now'),
		'reason_for_leaving' => Reason::all()->random(1)->pluck('reason')->first(),
    	'company_name' 		 => Client::all()->random(1)->pluck('client_name')->first(),
		'position' 	   		 => Position::all()->random(1)->pluck('position_name')->first(),
		'member_id' 		 => function(){
			return random_int(
					DB::table('members')->min('id'), 
					DB::table('members')->max('id')
				);
		},
    ];
});
