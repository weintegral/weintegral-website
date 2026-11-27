<?php

namespace Tests\Feature;

use Inertia\Testing\AssertableInertia;
use Tests\TestCase;

/**
 * The Contact page: the Visitor Request form beside the firm's contact details,
 * which every page already receives as shared site props.
 */
class ContactPageTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        // The Vite manifest is a build artifact; these tests only inspect the page object.
        $this->withoutVite();
    }

    public function test_contact_page_renders_the_contact_component_with_the_visitor_request_endpoint(): void
    {
        $this->get('/contact')
            ->assertOk()
            ->assertInertia(fn (AssertableInertia $page) => $page
                ->component('contact')
                ->where('visitorRequestUrl', '/api/visitor-request')
            );
    }

    /**
     * Contact details and offices come from the shared site props (SiteShellPropsTest),
     * built once for the whole site rather than again for this page.
     */
    public function test_contact_page_reuses_the_shared_contact_details_and_offices(): void
    {
        $this->get('/contact')
            ->assertInertia(fn (AssertableInertia $page) => $page
                ->missing('contactDetails')
                ->missing('offices')
                ->has('site.contact')
                ->has('site.offices', 2)
            );
    }
}
