<?php

use Faker\Generator as Faker;
use App\Models\Brand;

$factory->define(Brand::class, function (Faker $faker) {
    static $order = 0;
    
	$brands = [
		'Dell',
		'Jollibee',
		'Mang Inasal',
		'Taitech Marine',
    ];

    return [
        'brand_name' => $brands[$order++],
		'enabled' => 1,
		'business_unit_id'	=> function(){
			return random_int(
					DB::table('business_units')->min('id'),
					DB::table('business_units')->max('id')
				);
		},
		'last_modified_by' => $faker->firstName . " " . $faker->lastName
    ];
});
