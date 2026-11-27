<?php

namespace Tests\Browser;

use Illuminate\Support\Facades\Http;
use Laravel\Dusk\Browser;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\Browser\Concerns\ChecksAccessibility;
use Tests\DuskTestCase;

/**
 * Who We Are, Leadership and Industries as a visitor and a crawler meet them:
 * reached from the menus, server-rendered with their own SEO tags, accessible,
 * and with unconfirmed facts visibly marked.
 */
class AboutPagesTest extends DuskTestCase
{
    use ChecksAccessibility;

    private const SHELL_READY = 'header[data-hydrated="true"]';

    private const PRIMARY_NAV = 'nav[aria-label="Primary"]';

    private const OPEN_MENU = 'button[aria-label="Open menu"]';

    private const MOBILE_MENU = '[role="dialog"][data-slot="sheet-content"]';

    /**
     * Path, <title> and h1 of each page.
     *
     * @return array<string, array{string, string, string}>
     */
    public static function pages(): array
    {
        return [
            'who we are' => ['/about', 'Who We Are | WeIntegral', 'Who We Are'],
            'leadership' => ['/team', 'Leadership | WeIntegral', 'Leadership'],
            'industries' => ['/industries', 'Industries | WeIntegral', 'Industries'],
        ];
    }

    /**
     * @return array<string, array{string, string, string}>
     */
    public static function aboutMenuItems(): array
    {
        return [
            'who we are' => ['Who We Are', '/about', 'Who We Are | WeIntegral'],
            'leadership' => ['Leadership', '/team', 'Leadership | WeIntegral'],
        ];
    }

    #[DataProvider('aboutMenuItems')]
    public function test_about_menu_navigates_to_the_page(string $item, string $path, string $title): void
    {
        $this->browse(function (Browser $browser) use ($item, $path, $title) {
            $browser->resize(1440, 900)
                ->visit('/industries')
                ->waitFor(self::SHELL_READY)
                ->within(self::PRIMARY_NAV, fn (Browser $nav) => $nav
                    ->press('About')
                    ->waitForLink($item)
                    ->clickLink($item))
                ->waitForLocation($path)
                ->waitForTextIn('h1', $item)
                ->assertTitle($title);
        });
    }

    public function test_mobile_about_menu_navigates_to_leadership(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->resize(390, 844)
                ->visit('/about')
                ->waitFor(self::SHELL_READY)
                ->click(self::OPEN_MENU)
                ->waitFor(self::MOBILE_MENU)
                ->within(self::MOBILE_MENU, fn (Browser $menu) => $menu
                    ->press('About')
                    ->waitForLink('Leadership')
                    ->clickLink('Leadership'))
                ->waitForLocation('/team')
                ->waitForTextIn('h1', 'Leadership');
        });
    }

    public function test_industries_link_reaches_the_industries_page(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->resize(1440, 900)
                ->visit('/about')
                ->waitFor(self::SHELL_READY)
                ->within(self::PRIMARY_NAV, fn (Browser $nav) => $nav->clickLink('Industries'))
                ->waitForLocation('/industries')
                ->waitForTextIn('h1', 'Industries')
                ->assertSeeIn('main', 'Banking')
                ->assertSeeIn('main', 'Insurance')
                ->assertSeeIn('main', 'Ecommerce');
        });
    }

    public function test_who_we_are_marks_unconfirmed_statistics_and_shows_no_client_logos_or_testimonials(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->resize(1440, 900)
                ->visit('/about')
                ->waitFor(self::SHELL_READY)
                ->assertSeeIn('main', '1,463')
                ->assertSeeIn('section[aria-labelledby="numbers-heading"] [data-placeholder]', 'to confirm')
                ->assertMissing('img[src*="img/clients"]')
                ->assertDontSee('Saul Goodman')
                ->assertDontSee('Sara Wilsson');
        });
    }

    public function test_clients_url_redirects_to_who_we_are(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/clients')
                ->waitForLocation('/about')
                ->waitForTextIn('h1', 'Who We Are');
        });
    }

    #[DataProvider('pages')]
    public function test_page_passes_axe_in_light_and_dark_palettes(string $path, string $title, string $heading): void
    {
        $this->browse(function (Browser $browser) use ($path, $heading) {
            $browser->resize(1440, 900)->visit($path)->waitFor(self::SHELL_READY)->waitForTextIn('h1', $heading);
            $this->assertNoAxeViolations($browser);

            $this->emulateColorScheme($browser, 'dark');

            try {
                $browser->visit($path)->waitFor(self::SHELL_READY);
                $this->assertNoAxeViolations($browser);
            } finally {
                // The browser is shared with later tests.
                $this->emulateColorScheme($browser, 'light');
            }
        });
    }

    #[DataProvider('pages')]
    public function test_page_passes_axe_at_phone_width(string $path, string $title, string $heading): void
    {
        $this->browse(function (Browser $browser) use ($path, $heading) {
            $browser->resize(390, 844)->visit($path)->waitFor(self::SHELL_READY)->waitForTextIn('h1', $heading);
            $this->assertNoAxeViolations($browser);
        });
    }

    /**
     * Crawlers read the HTML the server sends, before any JavaScript runs.
     */
    #[DataProvider('pages')]
    public function test_server_rendered_html_carries_the_page_seo_tags(string $path, string $title, string $heading): void
    {
        $html = Http::get(rtrim(config('app.url'), '/').$path.'?utm_source=test')->throw()->body();
        $canonical = rtrim(config('app.url'), '/').$path;

        $this->assertMatchesRegularExpression('#<title[^>]*>'.preg_quote($title, '#').'</title>#', $html);
        $this->assertMatchesRegularExpression('#<meta[^>]+name="description"[^>]+content="[^"]{100,}"#', $html);
        $this->assertMatchesRegularExpression('#<link[^>]+rel="canonical"[^>]+href="'.preg_quote($canonical, '#').'"#', $html);
        $this->assertMatchesRegularExpression('#<meta[^>]+property="og:title"[^>]+content="'.preg_quote($title, '#').'"#', $html);
        $this->assertMatchesRegularExpression('#<meta[^>]+name="twitter:title"[^>]+content="'.preg_quote($title, '#').'"#', $html);
        $this->assertMatchesRegularExpression('#<h1[^>]*>'.preg_quote($heading, '#').'</h1>#', $html);
    }

    public function test_each_page_has_a_unique_meta_description(): void
    {
        $descriptions = array_map(function (array $page) {
            $html = Http::get(rtrim(config('app.url'), '/').$page[0])->throw()->body();
            preg_match('#<meta[^>]+name="description"[^>]+content="([^"]+)"#', $html, $match);

            return $match[1] ?? '';
        }, array_values(self::pages()) + [3 => ['/contact']]);

        $this->assertCount(4, array_unique(array_filter($descriptions)));
    }
}
