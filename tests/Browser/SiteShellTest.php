<?php

namespace Tests\Browser;

use Facebook\WebDriver\WebDriverKeys;
use Laravel\Dusk\Browser;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\Browser\Concerns\ChecksAccessibility;
use Tests\DuskTestCase;

/**
 * The shared site shell (utility bar, header menus, mobile menu, footer) on
 * Inertia pages. Menu items that lead to pages not yet migrated must still
 * reach the existing Blade pages.
 */
class SiteShellTest extends DuskTestCase
{
    use ChecksAccessibility;

    /** The header sets data-hydrated once React has taken over the server-rendered markup. */
    private const SHELL_READY = 'header[data-hydrated="true"]';

    private const PRIMARY_NAV = 'nav[aria-label="Primary"]';

    private const OPEN_MENU = 'button[aria-label="Open menu"]';

    private const MOBILE_MENU = '[role="dialog"][data-slot="sheet-content"]';

    /**
     * Opens the Contact page at a desktop (1440px) or phone (390px) viewport and waits
     * for hydration. Dusk reuses one browser per class, so every test sets its size.
     */
    private function visitContact(Browser $browser, bool $phone = false): Browser
    {
        return $browser->resize(...($phone ? [390, 844] : [1440, 900]))
            ->visit('/contact')
            ->waitFor(self::SHELL_READY);
    }

    /**
     * Desktop menu, item, destination path and the destination's <title>.
     *
     * @return array<string, array{string, string, string, string}>
     */
    public static function desktopMenuItems(): array
    {
        return [
            'services: application development' => ['Services', 'Application Development', '/app-development', 'WEI - App Dev'],
            'services: it staffing' => ['Services', 'IT Staffing', '/staffing', 'WEI - Staffing'],
            'services: view all' => ['Services', 'View all Services', '/services', 'WEI - Services'],
            'about: who we are' => ['About', 'Who We Are', '/about', 'WEI - About'],
            'about: leadership' => ['About', 'Leadership', '/team', 'WEI - Team'],
            'careers: open positions' => ['Careers', 'Open Positions', '/career/openings', 'Under Construction'],
            'careers: culture' => ['Careers', 'Culture', '/career/work-culture', 'Under Construction'],
            'careers: benefits' => ['Careers', 'Benefits', '/career/benefits', 'Under Construction'],
        ];
    }

    #[DataProvider('desktopMenuItems')]
    public function test_desktop_menu_opens_and_navigates(string $menu, string $item, string $path, string $title): void
    {
        $this->browse(function (Browser $browser) use ($menu, $item, $path, $title) {
            $this->visitContact($browser)
                ->within(self::PRIMARY_NAV, fn (Browser $nav) => $nav
                    ->press($menu)
                    ->waitForLink($item)
                    ->clickLink($item))
                ->waitForLocation($path)
                ->assertTitle($title);
        });
    }

    public function test_services_mega_menu_lists_the_five_services_and_a_call_to_action(): void
    {
        $this->browse(function (Browser $browser) {
            $this->visitContact($browser)
                ->within(self::PRIMARY_NAV, fn (Browser $nav) => $nav
                    ->press('Services')
                    ->waitForText('Not sure which Service fits?')
                    ->assertSeeLink('Application Development')
                    ->assertSeeLink('Application Support')
                    ->assertSeeLink('Quality Assurance & Testing')
                    ->assertSeeLink('DevOps & Cloud')
                    ->assertSeeLink('IT Staffing')
                    ->assertAttribute('a[data-menu-cta]', 'href', '/contact'));
        });
    }

    public function test_top_level_links_reach_industries_and_the_external_blog(): void
    {
        $this->browse(function (Browser $browser) {
            $this->visitContact($browser)
                ->assertAttribute(self::PRIMARY_NAV.' a[href^="https://blog.weintegral.com"]', 'target', '_blank')
                ->assertSeeIn(self::PRIMARY_NAV, 'Insights')
                ->within(self::PRIMARY_NAV, fn (Browser $nav) => $nav->clickLink('Industries'))
                ->waitForLocation('/industries')
                ->assertTitle('WEI - Industries');
        });
    }

    public function test_about_menu_no_longer_offers_clients(): void
    {
        $this->browse(function (Browser $browser) {
            $this->visitContact($browser)
                ->within(self::PRIMARY_NAV, fn (Browser $nav) => $nav
                    ->press('About')
                    ->waitForLink('Leadership')
                    ->assertDontSeeLink('Clients'))
                ->assertDontSeeIn('footer', 'Clients');
        });
    }

    public function test_keyboard_opens_a_menu_and_escape_closes_it_returning_focus(): void
    {
        $this->browse(function (Browser $browser) {
            $this->visitContact($browser);

            // The first button in the primary nav is the Services trigger.
            $services = self::PRIMARY_NAV.' button';

            $browser->keys($services, WebDriverKeys::ENTER)
                ->waitForText('Not sure which Service fits?')
                ->assertAttribute($services, 'aria-expanded', 'true');

            // Escape goes to whatever has focus, as a keyboard user would send it.
            $browser->driver->getKeyboard()->sendKeys(WebDriverKeys::ESCAPE);

            $browser->waitUntilMissingText('Not sure which Service fits?')
                ->assertAttribute($services, 'aria-expanded', 'false');

            $this->assertSame(
                'Services',
                trim($browser->script('return document.activeElement.textContent;')[0]),
            );
        });
    }

    public function test_talk_to_an_expert_and_utility_bar_links_are_always_present(): void
    {
        $this->browse(function (Browser $browser) {
            $this->visitContact($browser)
                ->assertAttribute('header a[data-header-cta]', 'href', '/contact')
                ->assertSeeLink('info@weintegral.com')
                ->assertSeeLink('Candidate Resources')
                ->clickLink('Careers')
                ->waitForLocation('/career')
                ->assertTitle('WEI - Career');
        });
    }

    public function test_footer_shows_contact_block_and_legal_links(): void
    {
        $this->browse(function (Browser $browser) {
            $this->visitContact($browser)
                ->within('footer', fn (Browser $footer) => $footer
                    ->assertSee('Lakeway, TX 78734')
                    ->assertSee('Andhra Pradesh, India - 523001')
                    ->assertSeeLink('+1 (512) 774-6577')
                    ->assertSee('West East Integral Inc.')
                    ->clickLink('Privacy Policy'))
                ->waitForLocation('/privacy-policy')
                ->assertTitle('Privacy Policy | WeIntegral');
        });
    }

    public function test_mobile_menu_opens_as_a_sheet_and_navigates(): void
    {
        $this->browse(function (Browser $browser) {
            $this->visitContact($browser, phone: true)
                ->assertMissing(self::PRIMARY_NAV)
                ->click(self::OPEN_MENU)
                ->waitFor(self::MOBILE_MENU)
                ->within(self::MOBILE_MENU, fn (Browser $menu) => $menu
                    // Services starts expanded.
                    ->assertSeeLink('Application Support')
                    ->assertSeeLink('Talk to an Expert')
                    ->press('Careers')
                    ->waitForLink('Benefits')
                    ->clickLink('Benefits'))
                ->waitForLocation('/career/benefits')
                ->assertTitle('Under Construction');
        });
    }

    public function test_mobile_menu_closes_with_escape(): void
    {
        $this->browse(function (Browser $browser) {
            $this->visitContact($browser, phone: true)
                ->click(self::OPEN_MENU)
                ->waitFor(self::MOBILE_MENU);

            $browser->driver->getKeyboard()->sendKeys(WebDriverKeys::ESCAPE);

            $browser->waitUntilMissing(self::MOBILE_MENU)
                ->assertFocused(self::OPEN_MENU);
        });
    }

    public function test_contact_page_passes_axe_on_desktop(): void
    {
        $this->browse(function (Browser $browser) {
            $this->visitContact($browser);

            $this->assertNoAxeViolations($browser);

            $browser->within(self::PRIMARY_NAV, fn (Browser $nav) => $nav
                ->press('Services')
                ->waitForText('Not sure which Service fits?'))
                // Let the fade-in finish so axe measures final colours.
                ->pause(400);

            $this->assertNoAxeViolations($browser);
        });
    }

    public function test_contact_page_passes_axe_in_the_dark_palette(): void
    {
        $this->browse(function (Browser $browser) {
            // Emulate before loading so axe never samples a colour transition mid-way.
            $this->emulateColorScheme($browser, 'dark');

            try {
                $this->visitContact($browser);

                $this->assertTrue($browser->script("return matchMedia('(prefers-color-scheme: dark)').matches;")[0]);
                $this->assertNoAxeViolations($browser);

                $browser->within(self::PRIMARY_NAV, fn (Browser $nav) => $nav
                    ->press('Services')
                    ->waitForText('Not sure which Service fits?'))
                    ->pause(400);

                $this->assertNoAxeViolations($browser);
            } finally {
                // The browser is shared with later tests.
                $this->emulateColorScheme($browser, 'light');
            }
        });
    }

    public function test_contact_page_passes_axe_with_the_mobile_menu_open(): void
    {
        $this->browse(function (Browser $browser) {
            $this->visitContact($browser, phone: true);

            $this->assertNoAxeViolations($browser);

            $browser->click(self::OPEN_MENU)->waitFor(self::MOBILE_MENU)->pause(400);

            $this->assertNoAxeViolations($browser);
        });
    }
}
