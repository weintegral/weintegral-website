<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Inertia\Testing\AssertableInertia;
use Tests\TestCase;

/**
 * Sample content lets the owner review the complete site locally: with
 * SITE_SAMPLE_CONTENT on, every page is marked "Sample content — not for
 * publication" and fictional values fill the gaps that await owner facts. It
 * is off by default and can never be switched on in production.
 */
class SampleContentTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->withoutVite();
        Cache::flush();
        Http::fake(['https://blog.weintegral.com/*' => Http::response('', 500)]);
    }

    private function enableSampleContent(): void
    {
        config(['site.sample_content' => true]);
    }

    public function test_sample_content_is_off_by_default(): void
    {
        $this->get('/contact')
            ->assertOk()
            ->assertInertia(fn (AssertableInertia $page) => $page->where('site.sample', null));
    }

    public function test_when_on_every_page_shares_the_sample_shell_content(): void
    {
        $this->enableSampleContent();

        $this->get('/contact')
            ->assertOk()
            ->assertInertia(fn (AssertableInertia $page) => $page
                ->where('site.sample.notice', 'Sample content — not for publication')
                ->where('site.sample.replyTime', fn (string $replyTime) => $replyTime !== '')
                ->has('site.sample.socialLinks', 3)
                ->where('site.sample.socialLinks.0', [
                    'label' => 'LinkedIn',
                    'href' => 'https://www.linkedin.com/company/example',
                ])
            );
    }

    public function test_when_on_the_homepage_shows_sample_statistics_testimonials_and_insights(): void
    {
        $this->enableSampleContent();

        $this->get('/')
            ->assertOk()
            ->assertInertia(fn (AssertableInertia $page) => $page
                ->has('statistics', 4)
                ->where('statistics.0.label', 'Clients served')
                ->whereNot('statistics.0.value', '110')
                ->has('testimonials', 3)
                ->has('testimonials.0', fn (AssertableInertia $testimonial) => $testimonial
                    ->whereAll(['name' => 'Jamie Carter', 'company' => 'Example Regional Bank'])
                    ->etc()
                )
                // The blog feed is down in this test, so sample posts stand in.
                ->has('insights', 3)
                ->where('sample.officeWork', fn (string $copy) => str_contains($copy, 'Ongole'))
            );
    }

    public function test_when_off_the_homepage_has_no_sample_values(): void
    {
        $this->get('/')
            ->assertOk()
            ->assertInertia(fn (AssertableInertia $page) => $page
                ->where('statistics.0.value', '110')
                ->where('testimonials', [])
                ->where('insights', [])
                ->where('sample', null)
            );
    }

    public function test_when_on_leadership_lists_sample_leaders_with_initials_avatars(): void
    {
        $this->enableSampleContent();

        $this->get('/team')
            ->assertOk()
            ->assertInertia(fn (AssertableInertia $page) => $page
                ->has('leaders', 4)
                ->where('leaders.0.name', 'Avery Morgan')
                ->where('leaders.0.initials', 'AM')
                ->where('leaders.0.photoUrl', null)
                ->where('leaders.0.linkedInUrl', 'https://www.linkedin.com/in/example')
            );
    }

    public function test_when_off_leadership_lists_no_leaders(): void
    {
        $this->get('/team')
            ->assertInertia(fn (AssertableInertia $page) => $page->where('leaders', []));
    }

    public function test_when_on_who_we_are_shows_sample_figures_and_story(): void
    {
        $this->enableSampleContent();

        $this->get('/about')
            ->assertOk()
            ->assertInertia(fn (AssertableInertia $page) => $page
                ->whereNot('stats.0.value', '110')
                ->where('sample.foundingStory', fn (string $copy) => str_contains($copy, 'started in'))
                ->where('sample.officeWork', fn (string $copy) => $copy !== '')
            );
    }

    public function test_when_off_who_we_are_keeps_the_figures_to_confirm(): void
    {
        $this->get('/about')
            ->assertInertia(fn (AssertableInertia $page) => $page
                ->where('stats.0.value', '110')
                ->where('sample', null)
            );
    }

    /**
     * @return array<string, array{string}>
     */
    public static function careersPages(): array
    {
        return [
            'careers' => ['/career'],
            'benefits' => ['/career/benefits'],
        ];
    }

    #[\PHPUnit\Framework\Attributes\DataProvider('careersPages')]
    public function test_careers_pages_get_sample_hiring_and_benefit_specifics_only_when_on(string $path): void
    {
        $this->get($path)->assertInertia(fn (AssertableInertia $page) => $page->where('sample', null));

        $this->enableSampleContent();

        $this->get($path)
            ->assertOk()
            ->assertInertia(fn (AssertableInertia $page) => $page
                ->where('sample.hiringSteps', fn (string $copy) => $copy !== '')
                ->where('sample.health', fn (string $copy) => $copy !== '')
                ->etc()
            );
    }

    public function test_when_on_the_services_overview_compares_sample_engagement_models(): void
    {
        $this->get('/services')->assertInertia(fn (AssertableInertia $page) => $page->where('sample', null));

        $this->enableSampleContent();

        $this->get('/services')
            ->assertOk()
            ->assertInertia(fn (AssertableInertia $page) => $page
                ->has('sample.engagementModels', 5)
                ->where('sample.engagementModels.0', [
                    'name' => 'Project-based delivery',
                    'whoManages' => 'WeIntegral',
                    'duration' => '2 to 9 months',
                    'bestFor' => 'A new application or a defined piece of work',
                ])
                ->where('sample.pricing', fn (string $copy) => $copy !== '')
            );
    }

    /**
     * @return array<string, array{string}>
     */
    public static function servicePages(): array
    {
        return [
            'application development' => ['/app-development'],
            'application support' => ['/app-support'],
            'testing' => ['/testing'],
            'devops' => ['/devops'],
            'staffing' => ['/staffing'],
        ];
    }

    #[\PHPUnit\Framework\Attributes\DataProvider('servicePages')]
    public function test_when_on_a_service_page_has_no_placeholders_left(string $path): void
    {
        $this->enableSampleContent();

        $response = $this->get($path)->assertOk();
        $service = $response->viewData('page')['props']['service'];

        $this->assertStringNotContainsString('"placeholder"', json_encode($service));
        $this->assertNotEmpty($service['engagementOptions']);
        $this->assertSame(['client', 'challenge', 'approach', 'result'], array_keys($service['caseStory']));
        $this->assertNotEmpty($service['technologies']['items']);
    }

    #[\PHPUnit\Framework\Attributes\DataProvider('servicePages')]
    public function test_when_off_a_service_page_keeps_its_placeholders(string $path): void
    {
        $this->get($path)
            ->assertOk()
            ->assertInertia(fn (AssertableInertia $page) => $page
                ->has('service.engagementOptions.placeholder')
                ->has('service.caseStory.placeholder')
            );
    }

    public function test_production_forces_sample_content_off(): void
    {
        $this->enableSampleContent();
        $this->app['env'] = 'production';

        $this->get('/contact')
            ->assertOk()
            ->assertInertia(fn (AssertableInertia $page) => $page->where('site.sample', null));
    }
}
