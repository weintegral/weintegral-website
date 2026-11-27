<?php

namespace Tests\Feature;

use Inertia\Testing\AssertableInertia;
use Tests\TestCase;

/**
 * The Contact page is the first page served through Inertia: Laravel owns the
 * contact details and hands them to the React page component as props.
 */
class ContactPageTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        // The Vite manifest is a build artifact; these tests only inspect the page object.
        $this->withoutVite();
    }

    public function test_contact_page_renders_the_contact_component_with_contact_details(): void
    {
        $this->get('/contact')
            ->assertOk()
            ->assertInertia(fn (AssertableInertia $page) => $page
                ->component('contact')
                ->where('contactDetails', [
                    'email' => 'info@weintegral.com',
                    'phone' => '+1 (512) 774-6577',
                ])
                ->where('offices', [
                    ['name' => 'Corporate Address', 'addressLines' => ['2009 Ranch Road, 620 N STE 113,', 'Lakeway, TX 78734']],
                    ['name' => 'Executive Office', 'addressLines' => ['2009 Ranch Road, 620 N STE 113,', 'Lakeway, TX 78734']],
                    ['name' => 'Overseas Office', 'addressLines' => ['VIJAYA PG, Anjaiah Road,', 'Ongole,', 'Andhra Pradesh, India - 523001']],
                ])
                ->where('visitorRequestUrl', '/api/visitor-request')
            );
    }
}
