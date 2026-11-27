<?php

namespace Tests\Browser;

use Illuminate\Support\Facades\Http;
use Laravel\Dusk\Browser;
use Tests\Browser\Concerns\ChecksAccessibility;
use Tests\DuskTestCase;

/**
 * The homepage, served through Inertia: its sections in the agreed order,
 * the hero's "Talk to an Expert" reaching Contact, working links, and axe.
 */
class HomePageTest extends DuskTestCase
{
    use ChecksAccessibility;

    private const SHELL_READY = 'header[data-hydrated="true"]';

    private function visitHome(Browser $browser, bool $phone = false): Browser
    {
        return $browser->resize(...($phone ? [390, 844] : [1440, 900]))
            ->visit('/')
            ->waitFor(self::SHELL_READY);
    }

    public function test_home_page_renders_its_sections_in_the_agreed_order(): void
    {
        $this->browse(function (Browser $browser) {
            $this->visitHome($browser)
                ->assertTitle('IT Services and IT Staffing | WeIntegral')
                ->assertSeeIn('h1', 'One team for the software your business runs on.');

            $headings = $browser->script(<<<'JS'
                return [...document.querySelectorAll('main section > div h2')].map((h) => h.textContent.trim());
                JS)[0];

            $this->assertSame([
                'Five Services. One accountable team.',
                'Why Clients choose WeIntegral',
                'Industries we serve',
                'From first conversation to running software',
                'Latest Insights',
                'Grow your career with WeIntegral',
                'Have a project or a role to fill? Let’s talk.',
            ], $headings);

            // Owner decisions: no client-logo wall; testimonials hidden until real ones exist.
            $browser->assertDontSee("Organizations we've worked with")
                ->assertMissing('#testimonials-heading')
                ->assertMissing('img[src*="/img/clients/"]');
        });
    }

    public function test_unconfirmed_statistics_carry_a_visible_to_confirm_marker(): void
    {
        $this->browse(function (Browser $browser) {
            $this->visitHome($browser)
                ->assertSeeIn('[data-statistics]', '110')
                ->assertSeeIn('[data-statistics]', 'Clients served')
                ->assertVisible('[data-statistics] [data-placeholder]')
                ->assertSeeIn('[data-statistics] [data-placeholder]', 'To confirm');
        });
    }

    public function test_hero_talk_to_an_expert_reaches_the_contact_page(): void
    {
        $this->browse(function (Browser $browser) {
            $this->visitHome($browser)
                ->click('a[data-hero-cta]')
                ->waitForLocation('/contact')
                ->waitForTextIn('h1', 'Contact')
                ->assertTitle('Contact | WeIntegral');
        });
    }

    public function test_every_link_in_the_page_content_resolves(): void
    {
        $this->browse(function (Browser $browser) {
            $hrefs = $this->visitHome($browser)->script(<<<'JS'
                return [...new Set([...document.querySelectorAll('main a[href]')].map((a) => a.getAttribute('href')))];
                JS)[0];

            $internal = array_values(array_filter($hrefs, fn (string $href) => str_starts_with($href, '/')));
            $external = array_values(array_diff($hrefs, $internal));

            // Services (line and list), Industries, careers, Contact: all on this site.
            foreach (['/app-development', '/app-support', '/testing', '/devops', '/staffing', '/services', '/industries', '/career/openings', '/career/work-culture', '/contact'] as $expected) {
                $this->assertContains($expected, $internal);
            }

            foreach ($internal as $href) {
                $response = Http::withoutRedirecting()->get(rtrim(config('app.url'), '/').$href);
                $this->assertSame(200, $response->status(), "$href returned {$response->status()}");
            }

            // Leaving the site: only the blog, the phone number and the email address.
            foreach ($external as $href) {
                $this->assertMatchesRegularExpression('#^(https://blog\.weintegral\.com(/|$)|tel:\+\d+$|mailto:)#', $href);
            }
            $this->assertContains('https://blog.weintegral.com', $external);
        });
    }

    public function test_insights_open_the_blog_in_a_new_tab(): void
    {
        $this->browse(function (Browser $browser) {
            $this->visitHome($browser);

            $targets = $browser->script(<<<'JS'
                return [...document.querySelectorAll('main a[href^="https://blog.weintegral.com"]')].map((a) => a.target + ' ' + a.rel);
                JS)[0];

            $this->assertNotEmpty($targets);
            $this->assertSame(['_blank noopener'], array_values(array_unique($targets)));
        });
    }

    public function test_home_page_passes_axe_in_the_light_palette(): void
    {
        $this->browse(function (Browser $browser) {
            // Let the Integral Line finish drawing.
            $this->visitHome($browser)->pause(1500);

            $this->assertNoAxeViolations($browser);
        });
    }

    public function test_home_page_passes_axe_in_the_dark_palette(): void
    {
        $this->browse(function (Browser $browser) {
            $this->emulateColorScheme($browser, 'dark');

            try {
                $this->visitHome($browser)->pause(1500);

                $this->assertTrue($browser->script("return matchMedia('(prefers-color-scheme: dark)').matches;")[0]);
                $this->assertNoAxeViolations($browser);
            } finally {
                // The browser is shared with later tests.
                $this->emulateColorScheme($browser, 'light');
            }
        });
    }

    public function test_home_page_passes_axe_on_a_phone(): void
    {
        $this->browse(function (Browser $browser) {
            $this->visitHome($browser, phone: true)->pause(400);

            $this->assertNoAxeViolations($browser);
        });
    }
}
