<?php

namespace Tests\Feature;

use Tests\TestCase;

/**
 * The OpenAPI spec is generated from the controllers by `composer api-docs:generate`
 * and served through Swagger UI.
 */
class ApiDocsTest extends TestCase
{
    public function test_swagger_ui_page_is_served(): void
    {
        $this->get('/swagger')->assertOk();
    }

    public function test_served_spec_documents_the_visitor_request_endpoint(): void
    {
        $this->get('/swagger/v1')
            ->assertOk()
            ->assertJsonPath('info.title', 'My First API')
            ->assertJsonPath('paths./api/visitor-request.post.summary', 'Create a new visitor request')
            ->assertJsonPath('paths./api/visitor-request.post.responses.201.description', 'Visitor request created successfully');
    }
}
