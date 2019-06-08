<?php

use Faker\Generator as Faker;
use App\Models\BusinessUnit;

$factory->define(BusinessUnit::class, function (Faker $faker) {
	$business_units = [
    	'Food and Drinks',
    	'Computer and Tech',
    	'Men and Women Fashion',
    	'Industrial and Construction',
	];
	
	$last_modified_by = [
    	'Ezra Paz',
        'Neil Nato',
        'Rachelle Uy',
        'Nards Paragas',
        'Jethru Aleria',
        'Jerome Agapay',
        'Patriz Malabanan',
	];

    $business_unit = $business_units[rand(0, count($business_units)-1)];
	$words = explode(" ", $business_unit);
	$code = "";

	foreach ($words as $w) {
		$code .= $w[0];
	}

    return [
        'business_unit_name' => $business_unit,
		'code' 		         => $code,
		'enabled' 	         => 1,
		'client_id'          => function(){
			return random_int(DB::table('clients')->min('id'), DB::table('clients')->max('id'));
		},
		'last_modified_by' => $last_modified_by[random_int(0, count($last_modified_by)-1)]
    ];
});
