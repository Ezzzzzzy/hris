<?php

use Faker\Generator as Faker;
use App\Models\{ BranchWorkHistory, Client, ClientWorkHistory };

$factory->define(BranchWorkHistory::class, function (Faker $faker) {

    $cwh_id = random_int(
            DB::table('client_work_histories')->min('id'),
            DB::table('client_work_histories')->max('id')
        );

    $date_start = $faker->dateTimeBetween('-6 years', 'now');
    $cwh = ClientWorkHistory::find($cwh_id);
    $cwh_date_end = $cwh->date_end ? $cwh->date_end : null;

    $client = Client::find($cwh->client_id);

    $client = $client->where("id", $cwh->client_id)
                ->with([
                    "brands" => function($q) {
                        $q->join("branches", "brands.id", "=", "branches.brand_id");
                        $q->select("branches.id");
                    },
                ])
                ->first();;

    $branches_id = $client->brands->map(function($value) {
        return $value->id;
    })->sort()->values();

    return [
        'status'=> $faker->numberBetween(0, 1),
        'date_start' => $date_start,
        'date_end' => $faker->boolean(50) ?  $faker->dateTimeBetween($date_start, 'now') : null,
        'enabled' => $faker->numberBetween(0, 1),
        'reason_for_leaving_remarks' => $faker->sentence(6),
        'client_work_history_id' => $cwh_id,
        'branch_id' => function() use ($branches_id){
            return random_int(
                    $branches_id->min(),
                    $branches_id->max()
                );
        },
        'reason_id' => function(){
            return random_int(
                    DB::table('reasons')->min('id'),
                    DB::table('reasons')->max('id')
                );
        },
        'position_id' => function(){
            return random_int(
                    DB::table('positions')->min('id'),
                    DB::table('positions')->max('id')
                );
        },
        'employment_status_id' => function(){
            return random_int(
                    DB::table('employment_statuses')->min('id'),
                    DB::table('employment_statuses')->max('id')
               );
        },
    ];
});