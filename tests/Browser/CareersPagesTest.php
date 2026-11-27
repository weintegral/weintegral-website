<?php

namespace Tests\Browser;

use Illuminate\Support\Facades\Http;
use Laravel\Dusk\Browser;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\Browser\Concerns\ChecksAccessibility;
use Tests\DuskTestCase;

/**
 * Careers (index, Culture, Benefits, Open Positions) and Candidate Resources as
 * a candidate sees them: server-rendered with SEO tags, accessible, and an Open
 * Positions table that can be searched and filtered.
 */
class CareersPagesTest extends DuskTestCase
{
    use ChecksAccessibility;

    private const HYDRATED = 'header[data-hydrated="true"]';

    private const POSITION_ROW = 'tr[data-position-row]';

    private const SEARCH = 'input[name="search"]';

    private const TECHNOLOGY = 'select[name="technology"]';

    /**
     * Path, <title> and H1 of every page this section owns.
     *
     * @return array<string, array{string, string, string}>
     */
    public static function pages(): array
    {
        return [
            'careers' => ['/career', 'Careers | WeIntegral', 'Careers'],
            'culture' => ['/career/work-culture', 'Culture | WeIntegral', 'Culture'],
            'benefits' => ['/career/benefits', 'Benefits | WeIntegral', 'Benefits'],
            'open positions' => ['/career/openings', 'Open Positions | WeIntegral', 'Open positions'],
            'candidate resources' => ['/resources', 'Candidate Resources | WeIntegral', 'Candidate resources'],
        ];
    }

    /**
     * The paths from pages(), for tests that only need the URL.
     *
     * @return array<string, array{string}>
     */
    public static function paths(): array
    {
        return array_map(fn (array $page): array => [$page[0]], self::pages());
    }

    private function visitAt(Browser $browser, string $path): Browser
    {
        return $browser->resize(1440, 900)->visit($path)->waitFor(self::HYDRATED);
    }

    private function rowCount(Browser $browser): int
    {
        return count($browser->elements(self::POSITION_ROW));
    }

    #[DataProvider('pages')]
    public function test_page_renders_with_its_title_heading_and_no_under_construction_notice(string $path, string $title, string $heading): void
    {
        $this->browse(function (Browser $browser) use ($path, $title, $heading) {
            $this->visitAt($browser, $path)
                ->assertPathIs($path)
                ->assertTitle($title)
                ->assertSeeIn('main h1', $heading)
                ->assertDontSee('under construction');
        });
    }

    #[DataProvider('paths')]
    public function test_page_passes_axe(string $path): void
    {
        $this->browse(function (Browser $browser) use ($path) {
            $this->emulateColorScheme($browser, 'light');
            $this->visitAt($browser, $path);

            $this->assertNoAxeViolations($browser);
        });
    }

    #[DataProvider('pages')]
    public function test_server_rendered_html_carries_seo_tags(string $path, string $title, string $heading): void
    {
        $html = Http::get(rtrim(config('app.url'), '/').$path.'?utm_source=test')->throw()->body();
        $canonical = rtrim(config('app.url'), '/').$path;

        $this->assertMatchesRegularExpression('#<title[^>]*>'.preg_quote($title, '#').'</title>#', $html);
        $this->assertMatchesRegularExpression('#<meta[^>]+name="description"[^>]+content="[^"]{80,}"#', $html);
        $this->assertMatchesRegularExpression('#<link[^>]+rel="canonical"[^>]+href="'.preg_quote($canonical, '#').'"#', $html);
        $this->assertMatchesRegularExpression('#<meta[^>]+property="og:title"[^>]+content="'.preg_quote($title, '#').'"#', $html);
        $this->assertMatchesRegularExpression('#<meta[^>]+name="twitter:description"[^>]+content="[^"]+"#', $html);
        $this->assertMatchesRegularExpression('#<h1[^>]*>'.preg_quote($heading, '#').'</h1>#', $html);
    }

    public function test_open_positions_search_filters_the_table_rows(): void
    {
        $this->browse(function (Browser $browser) {
            $this->visitAt($browser, '/career/openings')
                ->assertSeeIn('[data-result-count]', 'Showing 9 of 9 positions');
            $this->assertSame(9, $this->rowCount($browser));

            $browser->type(self::SEARCH, 'postgres')
                ->waitForTextIn('[data-result-count]', 'Showing 1 of 9 positions')
                ->assertSeeIn(self::POSITION_ROW, 'Database Admin');
            $this->assertSame(1, $this->rowCount($browser));
        });
    }

    public function test_open_positions_technology_filter_keeps_only_that_technology(): void
    {
        $this->browse(function (Browser $browser) {
            $this->visitAt($browser, '/career/openings')
                ->select(self::TECHNOLOGY, 'Node.js')
                ->waitForTextIn('[data-result-count]', 'Showing 3 of 9 positions');

            $this->assertSame(3, $this->rowCount($browser));
            foreach ($browser->elements(self::POSITION_ROW) as $row) {
                $this->assertStringContainsString('API Developer', $row->getText());
            }
        });
    }

    public function test_open_positions_shows_an_empty_state_when_nothing_matches_and_can_be_cleared(): void
    {
        $this->browse(function (Browser $browser) {
            $this->visitAt($browser, '/career/openings')
                ->type(self::SEARCH, 'cobol')
                ->waitFor('[data-empty-state]')
                ->assertSeeIn('[data-empty-state]', 'No positions match your search')
                ->assertSeeIn('[data-result-count]', 'Showing 0 of 9 positions')
                ->assertMissing('table');

            $this->assertNoAxeViolations($browser);

            $browser->press('Clear search and filters')
                ->waitFor(self::POSITION_ROW)
                ->assertInputValue(self::SEARCH, '');
            $this->assertSame(9, $this->rowCount($browser));
        });
    }

    public function test_apply_link_emails_the_careers_inbox_with_the_role_reference(): void
    {
        $this->browse(function (Browser $browser) {
            $this->visitAt($browser, '/career/openings')
                ->type(self::SEARCH, 'postgres')
                ->waitForTextIn('[data-result-count]', 'Showing 1 of 9 positions')
                ->assertAttributeContains(self::POSITION_ROW.' a', 'href', 'mailto:hr@weintegral.com?subject=Application%3A%20Database%20Admin%20(job-2023042909)');
        });
    }

    public function test_careers_menu_and_index_lead_to_open_positions(): void
    {
        $this->browse(function (Browser $browser) {
            $this->visitAt($browser, '/career/benefits')
                ->within('nav[aria-label="Primary"]', fn (Browser $nav) => $nav
                    ->press('Careers')
                    ->waitForLink('Open Positions')
                    ->clickLink('Open Positions'))
                ->waitForLocation('/career/openings')
                ->waitFor(self::POSITION_ROW);

            $this->visitAt($browser, '/career')
                ->assertSeeIn('[data-open-position-count]', '9 open positions right now')
                ->clickLink('Browse open positions')
                ->waitForLocation('/career/openings')
                ->assertTitle('Open Positions | WeIntegral');
        });
    }

    public function test_candidate_resources_are_reachable_from_the_footer_and_open_in_a_new_tab(): void
    {
        $this->browse(function (Browser $browser) {
            $this->visitAt($browser, '/career')
                ->within('footer', fn (Browser $footer) => $footer->clickLink('Candidate Resources'))
                ->waitForLocation('/resources')
                ->waitFor(self::HYDRATED)
                ->assertSeeLink('USCIS Case Status Online')
                ->assertDontSee('WeIntegral CRM')
                ->assertAttribute('a[href="https://egov.uscis.gov/casestatus/landing.do"]', 'target', '_blank');
        });
    }
}
