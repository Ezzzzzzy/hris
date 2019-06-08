<?php

namespace Tests\Unit;

use Carbon\Carbon;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Models\Member;

class AddMemberTest extends TestCase
{
    /** @test */
    function user_can_add_member_test()
    {
       $response = $this->json('POST', '/api/v1/members', [
           'status' => 200,
           'data'   => [
                'existing_member_id' 		  => 'SAMPLE-001',
                'new_member_id' 	 		  => 'PS-MEMBER1',
                'nickname' 			 		  => 'John',
                'last_name' 		 		  => 'Doe',
                'first_name' 	     		  => 'John',
                'middle_name' 		 		  => 'Dane',
                'extension_name' 	 		  => ' ',
                'present_address' 	 		  => 'Somewhere, Brgy. Saan, Random City',
                'permanent_address'  		  => 'Somewhere, Brgy. Saan, Random City',
                'height' 			 		  => '200',
                'weight' 			 		  => '76',
                'tin' 				 		  => '000-000-000-000',
                'sss_num' 			 		  => '00-00000000',
                'philhealth_num' 	 		  => '000000000000',
                'pag_ibig_num' 		 		  => '0000-0000-0000',
                'fb_address' 		 		  => 'jdoe@email.com',
                'email_address' 	 		  => 'jdoe@email.com',
                'civil_status' 		 		  => 'Single',
                'gender' 			 		  => 'M',
                'birthdate' 		 		  => '1989-01-01 17:45:29',
                'enabled' 			 		  => 1,
                'data_completion' 	 		  => 1,
                'address_cities_permanent_id' => 1,
                'address_cities_present_id'   => 1,
                'created_at' 				  => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' 				  => Carbon::now()->format('Y-m-d H:i:s'),
                'last_modified_by' 			  => 'Jane Doe'
           ]
       ]);
       
       $response
            ->assertStatus(200)
            ->assertJson([
                'status' => 200
            ]);
    }
}
