<?php

namespace Tests\Feature;

use App\Models\VisitorRequest;
use App\Services\Visitor;
use RuntimeException;
use Tests\TestCase;

/**
 * Creating a visitor request reports a storage failure as a RuntimeException that keeps the original cause.
 */
class VisitorServiceTest extends TestCase
{
    public function test_storage_failure_keeps_the_original_cause(): void
    {
        $cause = new \PDOException('database unavailable');
        VisitorRequest::saving(function () use ($cause): never {
            throw $cause;
        });

        try {
            (new Visitor())->createRequest([
                'name' => 'John Doe',
                'email' => 'john.doe@example.com',
                'subject' => 'Hello',
                'message' => 'Message content',
            ]);
            $this->fail('Expected a RuntimeException');
        } catch (RuntimeException $exception) {
            $this->assertSame('Error creating visitor request', $exception->getMessage());
            $this->assertSame($cause, $exception->getPrevious());
        }
    }
}
