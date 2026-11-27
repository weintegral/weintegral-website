<?php

namespace Tests\Browser;

use Illuminate\Support\Facades\Http;
use Tests\DuskTestCase;

/**
 * Crawlers read the HTML the server sends, before any JavaScript runs. Against
 * the full stack (web server plus the Inertia SSR process), the Contact page's
 * first response must already carry its SEO head and the site shell.
 */
class ServerRenderedSeoTest extends DuskTestCase
{
    private string $html;

    protected function setUp(): void
    {
        parent::setUp();

        $this->html = Http::get(rtrim(config('app.url'), '/').'/contact?utm_source=test')->throw()->body();
    }

    public function test_contact_html_carries_title_description_and_canonical(): void
    {
        $canonical = rtrim(config('app.url'), '/').'/contact';

        $this->assertMatchesRegularExpression('#<title[^>]*>Contact \| WeIntegral</title>#', $this->html);
        $this->assertMatchesRegularExpression('#<meta[^>]+name="description"[^>]+content="[^"]{50,}"#', $this->html);
        $this->assertMatchesRegularExpression('#<link[^>]+rel="canonical"[^>]+href="'.preg_quote($canonical, '#').'"#', $this->html);
    }

    public function test_contact_html_carries_open_graph_and_twitter_tags(): void
    {
        foreach (['og:type', 'og:site_name', 'og:title', 'og:description', 'og:url'] as $property) {
            $this->assertMatchesRegularExpression('#<meta[^>]+property="'.$property.'"[^>]+content="[^"]+"#', $this->html, "Missing $property");
        }

        foreach (['twitter:card', 'twitter:title', 'twitter:description'] as $name) {
            $this->assertMatchesRegularExpression('#<meta[^>]+name="'.$name.'"[^>]+content="[^"]+"#', $this->html, "Missing $name");
        }
    }

    public function test_contact_html_is_server_rendered_with_the_site_shell(): void
    {
        $this->assertStringContainsString('aria-label="Primary"', $this->html);
        $this->assertStringContainsString('Talk to an Expert', $this->html);
        $this->assertStringContainsString('West East Integral Inc.', $this->html);
        $this->assertMatchesRegularExpression('#<h1[^>]*>Contact</h1>#', $this->html);
    }

    public function test_home_html_is_server_rendered_with_its_seo_head(): void
    {
        $base = rtrim(config('app.url'), '/');
        $html = Http::get($base.'/?utm_source=test')->throw()->body();

        $this->assertMatchesRegularExpression('#<title[^>]*>IT Services and IT Staffing \| WeIntegral</title>#', $html);
        $this->assertMatchesRegularExpression('#<meta[^>]+name="description"[^>]+content="[^"]{50,}"#', $html);
        $this->assertMatchesRegularExpression('#<link[^>]+rel="canonical"[^>]+href="'.preg_quote($base, '#').'/?"#', $html);

        foreach (['og:type', 'og:title', 'og:description', 'og:url'] as $property) {
            $this->assertMatchesRegularExpression('#<meta[^>]+property="'.$property.'"[^>]+content="[^"]+"#', $html, "Missing $property");
        }

        foreach (['twitter:card', 'twitter:title', 'twitter:description'] as $name) {
            $this->assertMatchesRegularExpression('#<meta[^>]+name="'.$name.'"[^>]+content="[^"]+"#', $html, "Missing $name");
        }

        $this->assertMatchesRegularExpression('#<h1[^>]*>One team for the software your business runs on\.</h1>#', $html);
    }
}
