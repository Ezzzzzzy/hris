<?php

use Faker\Generator as Faker;
use App\Models\Reason;

$factory->define(Reason::class, function (Faker $faker) {
	static $order = 0;

	$reasons = [
		'Terminated',
		'Work Load',
		'Work Life Balance',
		'Work Environment/Culture',
		'Co-Workers',
		'Immediate Supervisor',
		'Health Reasons',
		'Career Growth',
		'Work Abroad',
		'Personal Reasons',
		'AWOL',
		'End of Service',

		'Transfer of Branch',
    ];

    return [
    	'reason' => $reasons[$order],
        'enabled' => 1,
        'order' => ++$order,
        'last_modified_by' => "Admin"
    ];
});
