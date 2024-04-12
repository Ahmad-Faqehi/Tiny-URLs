<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Urls;


class ShortTest extends TestCase
{
    /**
     * A basic unit test example.
     */
    public function test_creste_short_url(): void
    {   
        $response = $this->post('/api/create_short', ['url' => 'https://github.com/']);
        
        $response->assertStatus(200);
    }
    
    
    public function test_check_url(): void
    {   
        // $latest_uri = "sdssd";
        $latest_uri = Urls::latest()->value('uri_token');
        $response = $this->get('/s/'.$latest_uri);
        
        $response->assertStatus(302);
    }
}
