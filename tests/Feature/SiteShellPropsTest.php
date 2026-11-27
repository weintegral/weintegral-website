<?php

namespace Tests\Feature;

use Inertia\Testing\AssertableInertia;
use Tests\TestCase;

/**
 * Every Inertia page receives the data its shared shell (header, footer, SEO
 * head) needs, so the shell never hard-codes contact details or URLs.
 */
class SiteShellPropsTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->withoutVite();
    }

    public function test_inertia_pages_share_the_firm_contact_details_and_offices(): void
    {
        $this->get('/contact')
            ->assertOk()
            ->assertInertia(fn (AssertableInertia $page) => $page
                ->where('site.contact', [
                    'email' => 'info@weintegral.com',
                    'phone' => '+1 (512) 774-6577',
                ])
                ->where('site.offices', [
                    ['name' => 'Corporate office', 'addressLines' => ['2009 Ranch Road, 620 N STE 113,', 'Lakeway, TX 78734']],
                    ['name' => 'Overseas office', 'addressLines' => ['VIJAYA PG, Anjaiah Road,', 'Ongole,', 'Andhra Pradesh, India - 523001']],
                ])
            );
    }

    public function test_inertia_pages_share_the_services_from_the_service_catalog(): void
    {
        $this->get('/contact')
            ->assertInertia(fn (AssertableInertia $page) => $page
                ->has('site.services', 5)
                ->where('site.services.0', [
                    'name' => 'Application Development',
                    'href' => '/app-development',
                    'outcome' => 'Web and mobile applications built around your process',
                ])
                ->where('site.services.4.name', 'IT Staffing')
            );
    }

    public function test_inertia_pages_share_the_industries(): void
    {
        $this->get('/contact')
            ->assertInertia(fn (AssertableInertia $page) => $page
                ->where('site.industries', [
                    ['name' => 'Banking', 'summary' => null],
                    ['name' => 'Insurance', 'summary' => null],
                    ['name' => 'Ecommerce', 'summary' => null],
                ])
            );
    }

    public function test_inertia_pages_share_their_canonical_url_without_the_query_string(): void
    {
        $this->get('/contact?utm_source=newsletter')
            ->assertOk()
            ->assertInertia(fn (AssertableInertia $page) => $page
                ->where('site.canonicalUrl', url('/contact'))
            );
    }
}
