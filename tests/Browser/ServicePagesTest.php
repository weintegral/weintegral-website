<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\Browser\Concerns\ChecksAccessibility;
use Tests\DuskTestCase;

/**
 * A prospective Client reaches every Service page, and the Services overview,
 * from the Services menu, and each page is accessible.
 */
class ServicePagesTest extends DuskTestCase
{
    use ChecksAccessibility;

    private const SHELL_READY = 'header[data-hydrated="true"]';

    private const PRIMARY_NAV = 'nav[aria-label="Primary"]';

    private const ANCHOR_NAV = 'nav[aria-label="On this page"]';

    /**
     * Menu item, path, <title> and <h1>.
     *
     * @return array<string, array{string, string, string}>
     */
    public static function servicePages(): array
    {
        return [
            'application development' => ['Application Development', '/app-development', 'Application Development Services | WeIntegral'],
            'application support' => ['Application Support', '/app-support', 'Application Support and Maintenance | WeIntegral'],
            'quality assurance and testing' => ['Quality Assurance & Testing', '/testing', 'Quality Assurance and Software Testing | WeIntegral'],
            'devops and cloud' => ['DevOps & Cloud', '/devops', 'DevOps and Cloud Deployment | WeIntegral'],
            'it staffing' => ['IT Staffing', '/staffing', 'IT Staffing Services | WeIntegral'],
        ];
    }

    private function openFromServicesMenu(Browser $browser, string $item, string $path): Browser
    {
        return $browser->resize(1440, 900)
            ->visit('/contact')
            ->waitFor(self::SHELL_READY)
            ->within(self::PRIMARY_NAV, fn (Browser $nav) => $nav
                ->press('Services')
                ->waitForLink($item)
                ->clickLink($item))
            ->waitForLocation($path)
            ->waitFor(self::SHELL_READY);
    }

    #[DataProvider('servicePages')]
    public function test_service_page_opens_from_the_services_menu_and_passes_axe(string $name, string $path, string $title): void
    {
        $this->browse(function (Browser $browser) use ($name, $path, $title) {
            $this->openFromServicesMenu($browser, $name, $path)
                ->assertTitle($title)
                ->assertSeeIn('h1', $name)
                ->assertSeeIn('[aria-label="Breadcrumb"]', 'Services')
                ->assertSee('At a glance')
                ->assertSee('What you get')
                ->assertSee('How we deliver')
                ->assertSee('Questions Clients ask')
                ->assertSee('Related Services')
                ->assertAttribute('a[data-closing-cta]', 'href', '/contact');

            $this->assertNoAxeViolations($browser);
        });
    }

    public function test_in_page_navigation_jumps_to_a_section_and_marks_it_current(): void
    {
        $this->browse(function (Browser $browser) {
            $this->openFromServicesMenu($browser, 'Application Development', '/app-development')
                ->within(self::ANCHOR_NAV, fn (Browser $nav) => $nav->clickLink('FAQ'))
                ->assertFragmentIs('faq')
                ->waitFor(self::ANCHOR_NAV.' a[href="#faq"][aria-current="true"]');
        });
    }

    public function test_related_services_link_to_the_other_services(): void
    {
        $this->browse(function (Browser $browser) {
            $this->openFromServicesMenu($browser, 'IT Staffing', '/staffing')
                ->within('section[aria-labelledby="related-services-heading"]', fn (Browser $related) => $related
                    ->assertDontSeeLink('IT Staffing')
                    ->clickLink('DevOps & Cloud'))
                ->waitForLocation('/devops')
                ->assertSeeIn('h1', 'DevOps & Cloud');
        });
    }

    public function test_services_overview_opens_from_the_menu_and_links_every_service(): void
    {
        $this->browse(function (Browser $browser) {
            $this->openFromServicesMenu($browser, 'View all Services', '/services')
                ->assertTitle('IT Services | WeIntegral')
                ->assertSeeIn('h1', 'Services')
                ->assertSee('Discover')
                ->assertSee('Build')
                ->assertSee('Run');

            foreach (self::servicePages() as [$name, $path]) {
                $browser->assertPresent('main a[href="'.$path.'"]');
            }

            $this->assertNoAxeViolations($browser);

            $browser->click('main a[href="/testing"]')
                ->waitForLocation('/testing')
                ->assertSeeIn('h1', 'Quality Assurance & Testing');
        });
    }

    public function test_service_page_and_overview_pass_axe_in_the_dark_palette(): void
    {
        $this->browse(function (Browser $browser) {
            $this->emulateColorScheme($browser, 'dark');

            try {
                $browser->resize(1440, 900)->visit('/app-development')->waitFor(self::SHELL_READY);
                $this->assertNoAxeViolations($browser);

                $browser->visit('/services')->waitFor(self::SHELL_READY);
                $this->assertNoAxeViolations($browser);
            } finally {
                $this->emulateColorScheme($browser, 'light');
            }
        });
    }

    public function test_service_page_passes_axe_on_a_phone(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->resize(390, 844)->visit('/app-support')->waitFor(self::SHELL_READY);
            $this->assertNoAxeViolations($browser);

            $browser->visit('/services')->waitFor(self::SHELL_READY);
            $this->assertNoAxeViolations($browser);
        });
    }
}
