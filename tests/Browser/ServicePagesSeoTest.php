<?php

namespace Tests\Browser;

use Illuminate\Support\Facades\Http;
use Tests\DuskTestCase;

/**
 * Against the full stack (web server plus the Inertia SSR process), the first
 * HTML response of the Services overview and each Service page carries its own
 * title, description, canonical URL and sharing tags.
 */
class ServicePagesSeoTest extends DuskTestCase
{
    private const PATHS = ['/services', '/app-development', '/app-support', '/testing', '/devops', '/staffing'];

    public function test_each_service_page_is_server_rendered_with_unique_seo_tags(): void
    {
        $baseUrl = rtrim(config('app.url'), '/');
        $titles = [];
        $descriptions = [];

        foreach (self::PATHS as $path) {
            $html = Http::get($baseUrl.$path)->throw()->body();

            $this->assertMatchesRegularExpression('#<title[^>]*>([^<]+) \| WeIntegral</title>#', $html, "$path title");
            preg_match('#<title[^>]*>([^<]+)</title>#', $html, $title);
            preg_match('#<meta[^>]+name="description"[^>]+content="([^"]{50,})"#', $html, $description);
            $this->assertNotEmpty($description, "$path description");

            $this->assertMatchesRegularExpression('#<link[^>]+rel="canonical"[^>]+href="'.preg_quote($baseUrl.$path, '#').'"#', $html, "$path canonical");
            $this->assertMatchesRegularExpression('#<meta[^>]+property="og:title"[^>]+content="'.preg_quote($title[1], '#').'"#', $html, "$path og:title");
            $this->assertMatchesRegularExpression('#<meta[^>]+name="twitter:description"[^>]+content="[^"]+"#', $html, "$path twitter:description");
            $this->assertMatchesRegularExpression('#<h1[^>]*>[^<]+</h1>#', $html, "$path server-rendered h1");

            $titles[] = $title[1];
            $descriptions[] = $description[1];
        }

        $this->assertSame($titles, array_unique($titles), 'Titles must be unique');
        $this->assertSame($descriptions, array_unique($descriptions), 'Descriptions must be unique');
    }
}
