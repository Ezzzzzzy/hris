<?php

use Faker\Generator as Faker;
use App\Models\Region;

$factory->define(Region::class, function (Faker $faker) {
    static $order = 0;
    
    $regions =[
        "ILOCOS REGION", 
        "CAGAYAN VALLEY", 
        "CENTRAL LUZON", 
        "CALABARZON", 
        "MIMAROPA", 
        "BICOL REGION", 
        "WESTERN VISAYAS", 
        "CENTRAL VISAYAS", 
        "EASTERN VISAYAS", 
        "ZAMBOANGA PENINSULA", 
        "NORTHERN MINDANAO", 
        "DAVAO REGION", 
        "SOCCSKSARGEN", 
        "NCR", 
        "CAR", 
        "ARMM", "Caraga"
    ];
    
    return [
        'enabled' => 1,
        'region_name' => $regions[$order],
        'order' => ++$order,
        'last_modified_by'	=> "Admin",
    ];
});
