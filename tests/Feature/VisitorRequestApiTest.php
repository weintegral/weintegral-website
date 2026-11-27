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

    /**
     * The contact form maps these per-field messages onto its inputs.
     */
    public function test_rejected_fields_are_reported_per_field(): void
    {
        $this->postJson('/api/visitor-request', [
            'name' => 'John Doe',
            'email' => 'not-an-email',
            'subject' => 'Hello',
            'message' => str_repeat('a', 1001),
        ])
            ->assertStatus(422)
            ->assertJsonPath('errors.email.0', 'The email must be a valid email address.')
            ->assertJsonPath('errors.message.0', 'The message must not be greater than 1000 characters.')
            ->assertJsonMissingPath('errors.name')
            ->assertJsonMissingPath('errors.subject');
    }
}
