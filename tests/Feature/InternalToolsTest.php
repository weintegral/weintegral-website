<?php

namespace Tests\Feature;

use Inertia\Testing\AssertableInertia;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

/**
 * Internal Tools keep working at their URLs as Inertia pages, but tell search
 * engines not to index them (robots meta and X-Robots-Tag header) and stay out
 * of the sitemap.
 */
class InternalToolsTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->withoutVite();
    }

    /**
     * Path and the Inertia page component it renders.
     *
     * @return array<string, array{string, string}>
     */
    public static function internalTools(): array
    {
        return [
            'company systems' => ['/mgmt-resources', 'internal-tools/company-systems'],
            'vendors' => ['/vendors', 'internal-tools/vendors'],
            'job portals' => ['/job-portals', 'internal-tools/job-portals'],
            'client list' => ['/client-list', 'internal-tools/client-list'],
            'job groups' => ['/job-groups', 'internal-tools/job-groups'],
            'marketing submissions' => ['/marketing-data', 'internal-tools/marketing-submissions'],
            'marketing data' => ['/data', 'internal-tools/marketing-data'],
        ];
    }

    /**
     * @return array<string, array{string}>
     */
    public static function internalToolPaths(): array
    {
        return array_map(fn (array $case) => [$case[0]], self::internalTools());
    }

    #[DataProvider('internalTools')]
    public function test_internal_tool_resolves_to_its_inertia_page(string $path, string $component): void
    {
        $this->get($path)
            ->assertOk()
            ->assertInertia(fn (AssertableInertia $page) => $page->component($component));
    }

    #[DataProvider('internalToolPaths')]
    public function test_internal_tool_carries_noindex_meta_and_header(string $path): void
    {
        $response = $this->get($path);

        $response->assertOk();
        $response->assertHeader('X-Robots-Tag', 'noindex, nofollow');
        $response->assertSee('<meta name="robots" content="noindex, nofollow">', escape: false);
    }

    #[DataProvider('internalToolPaths')]
    public function test_internal_tool_is_not_in_the_sitemap(string $path): void
    {
        $this->assertStringNotContainsString(
            '<loc>'.url($path).'</loc>',
            $this->get('/sitemap.xml')->getContent(),
        );
    }

    public function test_public_pages_do_not_carry_noindex(): void
    {
        $response = $this->get('/contact');

        $response->assertHeaderMissing('X-Robots-Tag');
        $response->assertDontSee('name="robots"', escape: false);
    }

    public function test_company_systems_keep_their_legacy_url(): void
    {
        $this->assertSame(url('/mgmt-resources'), route('companySystemsPage'));
    }

    public function test_company_systems_list_the_staff_systems(): void
    {
        $this->get('/mgmt-resources')
            ->assertInertia(fn (AssertableInertia $page) => $page
                ->where('resources.0', [
                    'title' => 'WeIntegral Docs',
                    'brief' => 'WeIntegral Documentation',
                    'url' => 'https://docs.weintegral.com',
                ])
            );
    }

    public function test_vendors_list_name_job_page_and_approval(): void
    {
        $this->get('/vendors')
            ->assertInertia(fn (AssertableInertia $page) => $page
                ->where('vendors.0', [
                    'name' => 'TEK Systems',
                    'url' => 'https://careers.teksystems.com/us/en',
                    'verified' => false,
                ])
            );
    }

    public function test_job_groups_split_technologies_into_a_list(): void
    {
        $this->get('/job-groups')
            ->assertInertia(fn (AssertableInertia $page) => $page
                ->where('jobGroups.0.name', 'PHP Job Group')
                ->where('jobGroups.0.email', 'jobs-php@weintegral.com')
                ->where('jobGroups.0.technologies.0', 'PHP')
                ->where('jobGroups.0.technologies.1', 'Laravel')
            );
    }
}
