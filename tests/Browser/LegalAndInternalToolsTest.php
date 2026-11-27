<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\Browser\Concerns\ChecksAccessibility;
use Tests\DuskTestCase;

/**
 * Legal pages are reachable from the footer and accessible. Internal Tools
 * render in the new layout but are never linked from the public navigation.
 */
class LegalAndInternalToolsTest extends DuskTestCase
{
    use ChecksAccessibility;

    private const SHELL_READY = 'header[data-hydrated="true"]';

    private const OPEN_MENU = 'button[aria-label="Open menu"]';

    private const MOBILE_MENU = '[role="dialog"][data-slot="sheet-content"]';

    private const INTERNAL_TOOL_PATHS = [
        '/mgmt-resources',
        '/vendors',
        '/job-portals',
        '/client-list',
        '/job-groups',
        '/marketing-data',
        '/data',
    ];

    /**
     * Footer link, destination path and the page's <title> and <h1>.
     *
     * @return array<string, array{string, string, string, string}>
     */
    public static function legalPages(): array
    {
        return [
            'terms of service' => ['Terms of Service', '/terms-of-service', 'Terms of Service | WeIntegral', 'Terms of Service'],
            'privacy policy' => ['Privacy Policy', '/privacy-policy', 'Privacy Policy | WeIntegral', 'Privacy Policy'],
        ];
    }

    #[DataProvider('legalPages')]
    public function test_legal_page_is_reachable_from_the_footer(string $link, string $path, string $title, string $heading): void
    {
        $this->browse(function (Browser $browser) use ($link, $path, $title, $heading) {
            $browser->resize(1440, 900)
                ->visit('/contact')
                ->waitFor(self::SHELL_READY)
                ->within('footer', fn (Browser $footer) => $footer->clickLink($link))
                ->waitForLocation($path)
                ->assertTitle($title)
                ->assertSeeIn('h1', $heading)
                ->assertPresent('footer');
        });
    }

    #[DataProvider('legalPages')]
    public function test_legal_page_passes_axe(string $link, string $path): void
    {
        $this->browse(function (Browser $browser) use ($path) {
            $browser->resize(1440, 900)->visit($path)->waitFor(self::SHELL_READY);

            $this->assertNoAxeViolations($browser);
        });
    }

    #[DataProvider('legalPages')]
    public function test_legal_page_passes_axe_in_the_dark_palette(string $link, string $path): void
    {
        $this->browse(function (Browser $browser) use ($path) {
            $this->emulateColorScheme($browser, 'dark');

            try {
                $browser->resize(1440, 900)->visit($path)->waitFor(self::SHELL_READY);

                $this->assertNoAxeViolations($browser);
            } finally {
                $this->emulateColorScheme($browser, 'light');
            }
        });
    }

    public function test_internal_tools_are_absent_from_the_desktop_header_and_footer(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->resize(1440, 900)->visit('/contact')->waitFor(self::SHELL_READY);

            // Open every desktop menu so its links are in the DOM too.
            foreach (['Services', 'About', 'Careers'] as $menu) {
                $browser->within('nav[aria-label="Primary"]', fn (Browser $nav) => $nav->press($menu))->pause(200);
                $this->assertNoInternalToolLinks($browser, 'header');
            }

            $this->assertNoInternalToolLinks($browser, 'footer');
        });
    }

    public function test_internal_tools_are_absent_from_the_mobile_menu(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->resize(390, 844)
                ->visit('/contact')
                ->waitFor(self::SHELL_READY)
                ->click(self::OPEN_MENU)
                ->waitFor(self::MOBILE_MENU);

            foreach (['About', 'Careers'] as $menu) {
                $browser->within(self::MOBILE_MENU, fn (Browser $sheet) => $sheet->press($menu))->pause(200);
            }

            $this->assertNoInternalToolLinks($browser, self::MOBILE_MENU);
        });
    }

    /**
     * Path and the page's <h1>.
     *
     * @return array<string, array{string, string}>
     */
    public static function internalTools(): array
    {
        return [
            'management resources' => ['/mgmt-resources', 'Management resources'],
            'vendors' => ['/vendors', 'Vendors'],
            'job portals' => ['/job-portals', 'Job portals'],
            'client list' => ['/client-list', 'Client list'],
            'job groups' => ['/job-groups', 'Job groups'],
            'marketing submissions' => ['/marketing-data', 'Marketing submissions'],
            'marketing data' => ['/data', 'Marketing data'],
        ];
    }

    #[DataProvider('internalTools')]
    public function test_internal_tool_renders_in_the_new_layout_with_noindex(string $path, string $heading): void
    {
        $this->browse(function (Browser $browser) use ($path, $heading) {
            $browser->resize(1440, 900)
                ->visit($path)
                ->waitFor(self::SHELL_READY)
                ->assertPathIs($path)
                ->assertTitle($heading.' | WeIntegral')
                ->assertSeeIn('h1', $heading)
                ->assertPresent('footer')
                ->assertAttribute('meta[name="robots"]', 'content', 'noindex, nofollow');
        });
    }

    public function test_job_groups_list_technologies(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->resize(1440, 900)
                ->visit('/job-groups')
                ->waitFor(self::SHELL_READY)
                ->assertSeeIn('table', 'PHP Job Group')
                ->assertSeeLink('jobs-php@weintegral.com')
                ->assertSeeIn('table', 'Laravel');
        });
    }

    private function assertNoInternalToolLinks(Browser $browser, string $scope): void
    {
        $hrefs = $browser->script(sprintf(
            'return Array.from(document.querySelectorAll(%s)).map(a => new URL(a.href, location.href).pathname);',
            json_encode($scope.' a[href]'),
        ))[0];

        $this->assertNotEmpty($hrefs, "Expected links in $scope.");
        $this->assertSame([], array_values(array_intersect($hrefs, self::INTERNAL_TOOL_PATHS)), "Internal Tools linked from $scope.");
    }
}
