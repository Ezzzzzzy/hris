<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AddClientTest extends TestCase
{
    /** @test */
    function user_can_add_client_test()
    {
        $response = $this->json('POST', '/api/v1/clients', [
            'status' => 200,
            'data'   => [
                'client_name'      => 'Jollibee Food Corporation',
                'code'             => 'JFC',
                'last_modified_by' => 'Jerome Agapay',
                'enabled'          => 1
            ]            
        ]);
        
        $response
            ->assertStatus(200)
            ->assertJson([
                'status' => 200
            ]);
    }
}
