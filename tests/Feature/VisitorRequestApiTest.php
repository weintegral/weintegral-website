<?php

namespace Tests\Feature;

use App\Models\VisitorRequest;
use Tests\TestCase;

/**
 * The visitor-request API reports a storage failure as a JSON 500, not an unhandled error.
 */
class VisitorRequestApiTest extends TestCase
{
    public function test_storage_failure_returns_json_error(): void
    {
        VisitorRequest::saving(function (): never {
            throw new \PDOException('database unavailable');
        });

        $this->postJson('/api/visitor-request', [
            'name' => 'John Doe',
            'email' => 'john.doe@example.com',
            'subject' => 'Hello',
            'message' => 'Message content',
        ])
            ->assertStatus(500)
            ->assertExactJson(['message' => 'Error creating visitor request']);
    }
}
