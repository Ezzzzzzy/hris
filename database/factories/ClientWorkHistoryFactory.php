<?php

use Faker\Generator as Faker;
use App\Models\ClientWorkHistory;

$factory->define(ClientWorkHistory::class, function (Faker $faker) {
    // if member is still on going for a specific company
    $on_going = $faker->boolean(50);

    $date_start = $faker->dateTimeBetween('-2 years', 'now');
    $date_end = $on_going ? $faker->dateTimeBetween($date_start, "2019-01-10") : null;    

    $members_without_record = \DB::table("members")
                    ->whereNotIn("members.id", \DB::table("client_work_histories")->select("member_id"))
                    ->select("members.id")
                    ->get()->all();

    $members_with_date_end = \DB::table("members")
                    ->join("client_work_histories", "member_id", "=", "members.id")
                    ->where("client_work_histories.date_end", "!=", "null")
                    ->select("members.id")
                    ->get()->all();

    $available_members = [];

    foreach (array_merge(
        $members_with_date_end,
        $members_without_record
    ) as $key => $value) {
        array_push($available_members, $value->id);
    }

    return [
    	'status' => $faker->numberBetween(0, 1),
        'employee_id' => $faker->numerify('EX-####'),
    	'date_start' => $date_start,
    	'date_end' => $date_end,
    	'client_id' => function(){
    		return random_int(
                DB::table('clients')->min('id'),
                DB::table('clients')->max('id')
            ); 
    	},
    	'member_id' => function() use ($available_members){
    		return random_int(
                    min($available_members),
                    max($available_members)
                );
    	},
    	'tenure_type_id' => function(){
    		return random_int(
                    DB::table('tenure_types')->min('id'),
                    DB::table('tenure_types')->max('id')
                );
    	},
    ];
});