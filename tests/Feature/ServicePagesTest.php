<?php

namespace Tests\Feature;

use Inertia\Testing\AssertableInertia;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

/**
 * The Services overview and the five Service pages are Inertia pages at their
 * original URLs. Every Service page renders one shared component from the
 * Service's content, which Laravel owns.
 */
class ServicePagesTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->withoutVite();
    }

    /**
     * Path, Service name and SEO title.
     *
     * @return array<string, array{string, string, string}>
     */
    public static function servicePages(): array
    {
        return [
            'application development' => ['/app-development', 'Application Development', 'Application Development Services'],
            'application support' => ['/app-support', 'Application Support', 'Application Support and Maintenance'],
            'quality assurance and testing' => ['/testing', 'Quality Assurance & Testing', 'Quality Assurance and Software Testing'],
            'devops and cloud' => ['/devops', 'DevOps & Cloud', 'DevOps and Cloud Deployment'],
            'it staffing' => ['/staffing', 'IT Staffing', 'IT Staffing Services'],
        ];
    }

    #[DataProvider('servicePages')]
    public function test_service_page_renders_the_shared_service_component(string $path, string $name, string $seoTitle): void
    {
        $this->get($path)
            ->assertOk()
            ->assertInertia(fn (AssertableInertia $page) => $page
                ->component('services/show')
                ->where('service.name', $name)
                ->where('service.href', $path)
                ->where('service.seo.title', $seoTitle)
                ->has('service.seo.description')
                ->has('service.atAGlance', fn (AssertableInertia $items) => $items->each(fn (AssertableInertia $item) => $item->hasAll(['term', 'detail'])))
                ->has('service.pillars', 3)
                ->has('service.delivery.steps')
                ->has('service.faqs')
                // Every other Service is offered as a related Service.
                ->has('service.relatedServices', 4)
                ->where('service.relatedServices', fn ($related) => collect($related)->pluck('href')->doesntContain($path))
                ->etc()
            );
    }

    public function test_services_overview_lists_the_five_services_in_menu_order(): void
    {
        $this->get('/services')
            ->assertOk()
            ->assertInertia(fn (AssertableInertia $page) => $page
                ->component('services/index')
                ->where('services', fn ($services) => collect($services)->pluck('href')->all() === [
                    '/app-development', '/app-support', '/testing', '/devops', '/staffing',
                ])
                ->where('services.0.name', 'Application Development')
                ->where('services.0.outcome', 'Web and mobile applications built around your process')
                ->has('services.0.highlights', 3)
            );
    }

    public function test_every_service_has_a_unique_title_and_description(): void
    {
        $seo = collect(self::servicePages())->map(function (array $page) {
            $props = $this->get($page[0])->viewData('page')['props'];

            return $props['service']['seo'];
        });

        $this->assertSame($seo->count(), $seo->pluck('title')->unique()->count());
        $this->assertSame($seo->count(), $seo->pluck('description')->unique()->count());
        $seo->pluck('description')->each(fn (string $description) => $this->assertGreaterThanOrEqual(110, strlen($description), $description));
        $seo->pluck('description')->each(fn (string $description) => $this->assertLessThanOrEqual(165, strlen($description), $description));
    }

    /**
     * The homepage promises that every engagement follows Discover, Build, Run
     * (owner-confirmed), so each Service's delivery steps sit under those stages,
     * in that order, and use all three.
     */
    #[DataProvider('servicePages')]
    public function test_service_delivery_steps_map_onto_discover_build_run(string $path, string $name, string $seoTitle): void
    {
        $steps = $this->get($path)->viewData('page')['props']['service']['delivery']['steps'];
        $stages = array_column($steps, 'stage');

        $this->assertCount(count($steps), $stages, 'Every step names its stage');
        $this->assertSame(['Discover', 'Build', 'Run'], array_values(array_unique($stages)));
    }
}
