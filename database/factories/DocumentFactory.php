<?php

use Faker\Generator as Faker;
use App\Models\Document;

$factory->define(Document::class, function (Faker $faker) {
    $last_modified_by = [
        'Ezra Paz',
        'Neil Nato',
        'Rachelle Uy',
        'Nards Paragas',
        'Jerome Agapay',
        'Jethru Aleria',
        'Patriz Malabanan',
    ];

    return [
        'document_name'    	=> $faker->word . '.pdf',
        'path'             	=> '/public/documents/PDF',
        'last_modified_by' 	=> $last_modified_by[rand(0, count($last_modified_by)-1)],
        'member_id'        	=> function(){
        	return random_int(
                DB::table('members')->min('id'), 
                DB::table('members')->max('id')
            );
        },
        'document_type_id' 	=> function(){
        	return random_int(
                    DB::table('document_types')->min('id'), 
                    DB::table('document_types')->max('id')
                );
        },
    ];
});
