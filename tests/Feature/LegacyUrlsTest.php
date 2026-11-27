<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Http;
use Inertia\Testing\AssertableInertia;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

/**
 * Every URL the old Blade template served (the routes on `main` before spec #54)
 * still resolves after the template was removed: as an Inertia page, as the
 * owner-approved permanent redirect for the dropped Clients page, or as the
 * existing redirects to external sites.
 */
class LegacyUrlsTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        // The Vite manifest is a build artifact, and the homepage reads the external blog feed.
        $this->withoutVite();
        Http::fake();
    }

    /**
     * @return array<string, array{string}>
     */
    public static function pagePaths(): array
    {
        $paths = [
            '/',
            '/about',
            '/services',
            '/industries',
            '/terms-of-service',
            '/privacy-policy',
            '/app-development',
            '/app-support',
            '/testing',
            '/devops',
            '/staffing',
            '/career',
            '/career/work-culture',
            '/career/benefits',
            '/career/openings',
            '/team',
            '/contact',
            '/resources',
            '/marketing-data',
            '/data',
            '/mgmt-resources',
            '/vendors',
            '/job-portals',
            '/client-list',
            '/job-groups',
        ];

        return array_combine($paths, array_map(fn (string $path) => [$path], $paths));
    }

    #[DataProvider('pagePaths')]
    public function test_legacy_page_url_renders_an_inertia_page(string $path): void
    {
        $this->get($path)
            ->assertOk()
            ->assertInertia(fn (AssertableInertia $page) => $page->url($path));
    }

    public function test_legacy_clients_url_permanently_redirects_to_about(): void
    {
        $this->get('/clients')
            ->assertStatus(301)
            ->assertRedirect('/about');
    }

    /**
     * @return array<string, array{string, string}>
     */
    public static function externalRedirects(): array
    {
        return [
            'blog' => ['/blog', 'https://blog.weintegral.com'],
            'apps' => ['/apps', 'https://lnk.bio/weintegral'],
        ];
    }

    #[DataProvider('externalRedirects')]
    public function test_legacy_url_redirects_to_its_external_site(string $path, string $target): void
    {
        $this->get($path)->assertRedirect($target);
    }
}
