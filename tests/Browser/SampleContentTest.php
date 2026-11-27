<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\Browser\Concerns\ChecksAccessibility;
use Tests\DuskTestCase;

/**
 * With SITE_SAMPLE_CONTENT on, the owner can review the complete site: every page
 * carries the "Sample content — not for publication" banner, the sections that are
 * hidden or placeholders today show fictional values, and the pages stay accessible.
 *
 * The served app reads the .env that Dusk swaps in (.env.dusk.development), so these
 * tests switch the flag on in that file for their duration only.
 */
class SampleContentTest extends DuskTestCase
{
    use ChecksAccessibility;

    private const SHELL_READY = 'header[data-hydrated="true"]';

    private const BANNER = 'aside[aria-label="Sample content notice"]';

    private const FLAG = "\nSITE_SAMPLE_CONTENT=true\n";

    private ?string $originalEnv = null;

    protected function setUp(): void
    {
        parent::setUp();

        $this->originalEnv = file_get_contents(base_path('.env'));
        file_put_contents(base_path('.env'), $this->originalEnv.self::FLAG);
    }

    protected function tearDown(): void
    {
        if ($this->originalEnv !== null) {
            file_put_contents(base_path('.env'), $this->originalEnv);
        }

        parent::tearDown();
    }

    /**
     * @return array<string, array{string}>
     */
    public static function pages(): array
    {
        return [
            'home' => ['/'],
            'a service' => ['/app-support'],
            'leadership' => ['/team'],
            'an internal tool' => ['/vendors'],
        ];
    }

    #[DataProvider('pages')]
    public function test_every_page_shows_the_sample_content_banner(string $path): void
    {
        $this->browse(function (Browser $browser) use ($path) {
            $browser->resize(1440, 900)
                ->visit($path)
                ->waitFor(self::SHELL_READY)
                ->assertSeeIn(self::BANNER, 'Sample content — not for publication')
                ->assertMissing('[data-placeholder]');
        });
    }

    public function test_homepage_shows_sample_testimonials_and_figures(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->resize(1440, 900)
                ->visit('/')
                ->waitFor(self::SHELL_READY)
                ->assertSeeIn('section[aria-labelledby="testimonials-heading"]', 'Jamie Carter')
                ->assertSeeIn('section[aria-labelledby="testimonials-heading"]', 'Example Regional Bank')
                ->assertSeeIn('[data-statistics]', '9,600')
                ->assertSeeIn('section[aria-labelledby="closing-heading"]', 'We reply within one business day.')
                ->assertPresent('footer a[href="https://www.linkedin.com/company/example"]');
        });
    }

    public function test_service_page_shows_sample_engagement_options_and_case_story(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->resize(1440, 900)
                ->visit('/app-support')
                ->waitFor(self::SHELL_READY)
                ->assertSeeIn('#engagement-options', 'Managed support')
                ->assertSeeIn('[data-case-story]', 'Example Regional Bank')
                ->assertSeeIn('[data-case-story]', 'Result');
        });
    }

    public function test_leadership_shows_sample_leaders_with_initials_avatars(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->resize(1440, 900)
                ->visit('/team')
                ->waitFor(self::SHELL_READY)
                ->assertSeeIn('main', 'Avery Morgan')
                ->assertSeeIn('[data-initials-avatar]', 'AM')
                ->assertMissing('[data-leaders-placeholder]');
        });
    }

    /**
     * @return array<string, array{string, string}>
     */
    public static function axePages(): array
    {
        return [
            'home, light' => ['/', 'light'],
            'home, dark' => ['/', 'dark'],
            'services overview, light' => ['/services', 'light'],
            'a service, light' => ['/app-support', 'light'],
            'leadership, light' => ['/team', 'light'],
        ];
    }

    #[DataProvider('axePages')]
    public function test_sample_pages_pass_axe(string $path, string $scheme): void
    {
        $this->browse(function (Browser $browser) use ($path, $scheme) {
            $this->emulateColorScheme($browser, $scheme);
            $browser->resize(1440, 900)
                ->visit($path)
                ->waitFor(self::SHELL_READY)
                ->waitFor(self::BANNER);

            $this->assertNoAxeViolations($browser);
        });
    }
}
