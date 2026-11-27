<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_the_application_returns_a_successful_response()
    {
        // The homepage reads the external blog feed; never reach the network from tests.
        Http::fake();
        $this->withoutVite();

        $response = $this->get('/');

        $response->assertStatus(200);
    }
}
