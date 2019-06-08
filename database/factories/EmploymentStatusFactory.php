<?php

use Faker\Generator as Faker;
use App\Models\EmploymentStatus;

$factory->define(EmploymentStatus::class, function (Faker $faker) {
    static $order = 0;
    
    $employment_statuses = [
        // type = inactive
        'Floating',
        'Resigned',
        'Terminated',
        'Blacklisted',

        // type = active
        'Training',
        'Probationary',
        'Seasonal',
        'Regular',
        'Weekender',
        'Part-Timer',
        'Reliever',
    ];

    return [
        'status_name' => $employment_statuses[$order],
        'type' => $order < 4 ? 'inactive' : 'active',
        'enabled' => 1,
        'order' => ++$order,
        'color' => $faker->unique()->hexcolor,
        'last_modified_by' => "Admin",
    ];
});
