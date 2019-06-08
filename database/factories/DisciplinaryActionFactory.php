<?php

use Faker\Generator as Faker;
use App\Models\DisciplinaryAction;

$factory->define(DisciplinaryAction::class, function (Faker $faker) {
    return [
        'date_of_incident' 			=> $faker->dateTimeBetween('-6 years', $endDate = '-5 months'),
        'incident_report' 			=> $faker->sentence('15'),
        'date_of_notice_to_explain' => $faker->dateTimeBetween('-6 years', $endDate = '-5 months'),
        'date_of_explanation' 		=> $faker->dateTimeBetween('-6 years', $endDate = '-5 months'),
        'decision' 					=> $faker->sentence('10'),
        'date_of_decision' 			=> $faker->dateTimeBetween('-6 years', $endDate = '-5 months'),
        'status' 					=> $faker->numberBetween(0,1),
        'branch_work_history_id' => function(){
        	return random_int(DB::table('branch_work_histories')->min('id'), DB::table('branch_work_histories')->max('id'));
        },
    ];
});
