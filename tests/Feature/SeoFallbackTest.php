<?php

namespace Tests\Feature;

use Inertia\Ssr\Gateway;
use Inertia\Ssr\Response as SsrResponse;
use Inertia\Testing\AssertableInertia;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

/**
 * Crawlers read the first HTML response. When the Inertia SSR process is down,
 * the root view still renders each page's title, description, canonical URL and
 * Open Graph tags from its `seo` page prop; when SSR is up it adds nothing, so the
 * SSR-rendered tags are never duplicated.
 */
class SeoFallbackTest extends TestCase
{
    private const ABOUT_DESCRIPTION = 'WeIntegral builds, tests, deploys and supports business applications and staffs IT roles, from offices in Lakeway, Texas and Ongole, India.';

    protected function setUp(): void
    {
        parent::setUp();

        $this->withoutVite();
    }

    /**
     * Every public page, with the page title its `seo` prop carries.
     *
     * @return array<string, array{string, string}>
     */
    public static function publicPages(): array
    {
        return [
            'home' => ['/', 'IT Services and IT Staffing'],
            'who we are' => ['/about', 'Who We Are'],
            'leadership' => ['/team', 'Leadership'],
            'industries' => ['/industries', 'Industries'],
            'services' => ['/services', 'IT Services'],
            'a service' => ['/devops', 'DevOps and Cloud Deployment'],
            'careers' => ['/career', 'Careers'],
            'culture' => ['/career/work-culture', 'Culture'],
            'benefits' => ['/career/benefits', 'Benefits'],
            'open positions' => ['/career/openings', 'Open Positions'],
            'candidate resources' => ['/resources', 'Candidate Resources'],
            'contact' => ['/contact', 'Contact'],
            'terms of service' => ['/terms-of-service', 'Terms of Service'],
            'privacy policy' => ['/privacy-policy', 'Privacy Policy'],
        ];
    }

    #[DataProvider('publicPages')]
    public function test_public_page_carries_its_seo_metadata_as_a_page_prop(string $path, string $title): void
    {
        $this->get($path)
            ->assertOk()
            ->assertInertia(fn (AssertableInertia $page) => $page
                ->where('seo.title', $title)
                ->where('seo.description', fn (string $description) => strlen($description) >= 80)
            );
    }

    public function test_without_ssr_the_root_view_renders_the_seo_head_from_page_props(): void
    {
        $response = $this->get('/about?utm_source=newsletter');

        $response->assertOk();
        $response->assertSee('<title data-inertia="">Who We Are | WeIntegral</title>', escape: false);
        $response->assertSee('<meta name="description" content="'.self::ABOUT_DESCRIPTION.'" data-inertia="description">', escape: false);
        $response->assertSee('<link rel="canonical" href="'.url('/about').'" data-inertia="canonical">', escape: false);
        $response->assertSee('<meta property="og:title" content="Who We Are | WeIntegral" data-inertia="og:title">', escape: false);
        $response->assertSee('<meta property="og:description" content="'.self::ABOUT_DESCRIPTION.'" data-inertia="og:description">', escape: false);
        $response->assertSee('<meta property="og:url" content="'.url('/about').'" data-inertia="og:url">', escape: false);
    }

    public function test_every_page_shares_a_default_social_image_as_a_large_card(): void
    {
        $image = url('/img/social/default-share.jpg');

        $this->get('/about')
            ->assertInertia(fn (AssertableInertia $page) => $page->where('site.shareImage', [
                'url' => $image,
                'width' => 1200,
                'height' => 630,
                'alt' => 'A team working on laptops around a shared table',
            ]))
            ->assertSee('<meta property="og:image" content="'.$image.'" data-inertia="og:image">', escape: false)
            ->assertSee('<meta name="twitter:card" content="summary_large_image" data-inertia="twitter:card">', escape: false);

        $this->assertFileExists(public_path('img/social/default-share.jpg'));
    }

    public function test_without_ssr_the_fallback_escapes_the_copy(): void
    {
        $this->get('/services')
            ->assertSee('content="WeIntegral&#039;s IT services:', escape: false);
    }

    public function test_with_ssr_up_only_the_server_rendered_head_is_sent(): void
    {
        $this->app->instance(Gateway::class, new class implements Gateway
        {
            public function dispatch(array $page): ?SsrResponse
            {
                return new SsrResponse(
                    '<title data-inertia="">From SSR</title><meta name="description" content="From SSR" data-inertia="description">',
                    '<div id="app">SSR body</div>',
                );
            }
        });

        $html = $this->get('/about')->assertOk()->getContent();

        $this->assertSame(1, substr_count($html, 'name="description"'));
        $this->assertSame(1, substr_count($html, '<title'));
        $this->assertStringNotContainsString(self::ABOUT_DESCRIPTION, $html);
        $this->assertStringNotContainsString('rel="canonical"', $html);
    }

    public function test_internal_tools_get_no_seo_fallback(): void
    {
        $response = $this->get('/vendors');

        $response->assertOk();
        $response->assertSee('<title data-inertia="">WeIntegral</title>', escape: false);
        $response->assertDontSee('name="description"', escape: false);
    }
}
