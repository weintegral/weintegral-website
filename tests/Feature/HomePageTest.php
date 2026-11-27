<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Inertia\Testing\AssertableInertia;
use Tests\TestCase;

/**
 * The homepage is an Inertia page: Laravel owns its facts (statistics awaiting
 * owner confirmation, testimonials, latest Insights from the blog feed) and
 * hands them to the React `home` component as props.
 */
class HomePageTest extends TestCase
{
    private const FEED_URL = 'https://blog.weintegral.com/rss.xml';

    protected function setUp(): void
    {
        parent::setUp();

        // The Vite manifest is a build artifact; these tests only inspect the page object.
        $this->withoutVite();
        Cache::flush();
    }

    public function test_home_page_renders_the_home_component_with_statistics_and_no_testimonials(): void
    {
        Http::fake([self::FEED_URL => Http::response('', 500)]);

        $this->get('/')
            ->assertOk()
            ->assertInertia(fn (AssertableInertia $page) => $page
                ->component('home')
                ->where('statistics', [
                    ['value' => '110', 'label' => 'Clients served'],
                    ['value' => '150', 'label' => 'Projects delivered'],
                    ['value' => '1,463', 'label' => 'Hours of support'],
                    ['value' => '25', 'label' => 'Employees'],
                ])
                // The current site's testimonials are template placeholders and must never be published.
                ->where('testimonials', [])
                ->has('insights')
            );
    }

    public function test_latest_insights_come_from_the_blog_feed_newest_first_at_most_three(): void
    {
        Http::fake([self::FEED_URL => Http::response(<<<'XML'
            <?xml version="1.0" encoding="UTF-8"?>
            <rss version="2.0"><channel><title>WEIntegral Blog</title>
              <item><title><![CDATA[Older post]]></title><link>https://blog.weintegral.com/older</link><pubDate>Mon, 01 Jan 2024 10:00:00 GMT</pubDate></item>
              <item><title><![CDATA[Newest post]]></title><link>https://blog.weintegral.com/newest</link><pubDate>Fri, 02 Feb 2024 22:38:00 GMT</pubDate></item>
              <item><title><![CDATA[Middle post]]></title><link>https://blog.weintegral.com/middle</link><pubDate>Mon, 15 Jan 2024 10:00:00 GMT</pubDate></item>
              <item><title><![CDATA[Oldest post]]></title><link>https://blog.weintegral.com/oldest</link><pubDate>Fri, 01 Dec 2023 10:00:00 GMT</pubDate></item>
            </channel></rss>
            XML)]);

        $this->get('/')
            ->assertOk()
            ->assertInertia(fn (AssertableInertia $page) => $page
                ->component('home')
                ->where('insights', [
                    ['title' => 'Newest post', 'url' => 'https://blog.weintegral.com/newest', 'publishedOn' => '2024-02-02'],
                    ['title' => 'Middle post', 'url' => 'https://blog.weintegral.com/middle', 'publishedOn' => '2024-01-15'],
                    ['title' => 'Older post', 'url' => 'https://blog.weintegral.com/older', 'publishedOn' => '2024-01-01'],
                ])
            );
    }

    public function test_latest_insights_are_empty_when_the_blog_feed_is_unreachable(): void
    {
        Http::fake([self::FEED_URL => Http::failedConnection()]);

        $this->get('/')
            ->assertOk()
            ->assertInertia(fn (AssertableInertia $page) => $page
                ->component('home')
                ->where('insights', [])
            );
    }

    public function test_latest_insights_skip_links_off_the_blog_and_unparseable_dates(): void
    {
        Http::fake([self::FEED_URL => Http::response(<<<'XML'
            <?xml version="1.0"?>
            <rss version="2.0"><channel>
              <item><title>Phishing</title><link>javascript:alert(1)</link><pubDate>Fri, 02 Feb 2024 22:38:00 GMT</pubDate></item>
              <item><title>Elsewhere</title><link>https://example.com/post</link><pubDate>Fri, 02 Feb 2024 22:38:00 GMT</pubDate></item>
              <item><title>Kept</title><link>https://blog.weintegral.com/kept</link><pubDate>not a date</pubDate></item>
            </channel></rss>
            XML)]);

        $this->get('/')
            ->assertInertia(fn (AssertableInertia $page) => $page
                ->where('insights', [
                    ['title' => 'Kept', 'url' => 'https://blog.weintegral.com/kept', 'publishedOn' => null],
                ])
            );
    }

    public function test_latest_insights_are_empty_when_the_feed_is_not_xml(): void
    {
        Http::fake([self::FEED_URL => Http::response('<html>not xml')]);

        $this->get('/')
            ->assertOk()
            ->assertInertia(fn (AssertableInertia $page) => $page->where('insights', []));
    }

    public function test_the_blog_feed_is_cached_between_visits(): void
    {
        Http::fake([self::FEED_URL => Http::response('<rss version="2.0"><channel></channel></rss>')]);

        $this->get('/')->assertOk();
        $this->get('/')->assertOk();

        Http::assertSentCount(1);
    }
}
