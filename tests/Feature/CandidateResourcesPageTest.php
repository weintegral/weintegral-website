<?php

namespace Tests\Feature;

use Inertia\Testing\AssertableInertia;
use Tests\TestCase;

/**
 * Candidate Resources stays public at /resources: the visa and H-1B links from
 * the Resource service, never the company-systems links from Internal Tools.
 */
class CandidateResourcesPageTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->withoutVite();
    }

    public function test_candidate_resources_page_lists_the_public_candidate_links(): void
    {
        $this->get('/resources')
            ->assertOk()
            ->assertInertia(fn (AssertableInertia $page) => $page
                ->component('candidate-resources')
                ->has('candidateResources', 12)
                ->where('candidateResources.0', [
                    'title' => 'USCIS Case Status Online',
                    'brief' => 'Track the status of an immigration application, petition, or request',
                    'url' => 'https://egov.uscis.gov/casestatus/landing.do',
                ])
                ->where('candidateResources.11.title', 'Extension of OPT')
            );
    }

    public function test_candidate_resources_page_leaves_out_internal_tools_links(): void
    {
        $this->get('/resources')
            ->assertInertia(fn (AssertableInertia $page) => $page
                ->where('candidateResources', fn ($resources) => collect($resources)
                    ->pluck('url')
                    ->intersect(['https://crm.weintegral.com', 'https://docs.weintegral.com', 'https://app.clockify.me'])
                    ->isEmpty())
            );
    }
}
