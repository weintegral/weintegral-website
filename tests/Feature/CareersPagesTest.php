<?php

namespace Tests\Feature;

use App\Services\Job;
use Inertia\Testing\AssertableInertia;
use Tests\TestCase;

/**
 * The Careers section (index, Culture, Benefits, Open Positions) is served
 * through Inertia at its existing URLs; Laravel owns the job data.
 */
class CareersPagesTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->withoutVite();
    }

    public function test_careers_index_renders_with_the_open_position_count_and_careers_email(): void
    {
        $this->get('/career')
            ->assertOk()
            ->assertInertia(fn (AssertableInertia $page) => $page
                ->component('careers/index')
                ->where('openPositionCount', 9)
                ->where('careersEmail', 'hr@weintegral.com')
            );
    }

    public function test_culture_page_renders_the_culture_component(): void
    {
        $this->get('/career/work-culture')
            ->assertOk()
            ->assertInertia(fn (AssertableInertia $page) => $page->component('careers/culture'));
    }

    public function test_benefits_page_renders_the_benefits_component(): void
    {
        $this->get('/career/benefits')
            ->assertOk()
            ->assertInertia(fn (AssertableInertia $page) => $page->component('careers/benefits'));
    }

    public function test_open_positions_page_lists_every_job_as_a_typed_open_position(): void
    {
        $this->get('/career/openings')
            ->assertOk()
            ->assertInertia(fn (AssertableInertia $page) => $page
                ->component('careers/open-positions')
                ->has('openPositions', 9)
                ->where('openPositions.0', [
                    'id' => 'job-2023042901',
                    'role' => 'Backend Developer',
                    'technology' => 'PHP',
                    'summary' => 'PHP Engineer with Laravel, Docker & AWS experience',
                    'skills' => ['PHP', 'SQL', 'Laravel'],
                ])
                ->where('openPositions.1.technology', 'Node.js')
                ->where('openPositions.1.skills', ['Node.js', 'SQL', 'Express.js'])
                ->where('careersEmail', 'hr@weintegral.com')
            );
    }

    public function test_open_positions_page_passes_an_empty_list_when_there_are_no_openings(): void
    {
        $this->mock(Job::class)->shouldReceive('getLatestRequirements')->andReturn([]);

        $this->get('/career/openings')
            ->assertOk()
            ->assertInertia(fn (AssertableInertia $page) => $page
                ->component('careers/open-positions')
                ->where('openPositions', [])
            );
    }
}
