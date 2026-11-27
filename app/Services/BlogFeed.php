<?php

namespace App\Services;

use Carbon\CarbonImmutable;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Throwable;

/**
 * The latest Insights: posts read from the external blog's RSS feed.
 *
 * The blog is a third-party host, so the feed is cached and every failure
 * (timeout, error status, malformed XML) yields an empty list. The homepage
 * then shows marked placeholders instead of failing.
 */
class BlogFeed
{
    public const BLOG_URL = 'https://blog.weintegral.com';

    private const FEED_URL = self::BLOG_URL.'/rss.xml';

    private const CACHE_KEY = 'blog-feed.latest-insights';

    private const CACHE_SECONDS = 3600;

    /** A failed fetch is retried sooner than a good one is refreshed. */
    private const FAILURE_CACHE_SECONDS = 600;

    /**
     * Newest posts first.
     *
     * @return list<array{title: string, url: string, publishedOn: string|null}>
     */
    public function latestInsights(int $limit = 3): array
    {
        $insights = Cache::get(self::CACHE_KEY);

        if (! is_array($insights)) {
            $insights = $this->fetch();
            Cache::put(self::CACHE_KEY, $insights, $insights === [] ? self::FAILURE_CACHE_SECONDS : self::CACHE_SECONDS);
        }

        return array_slice($insights, 0, $limit);
    }

    /**
     * @return list<array{title: string, url: string, publishedOn: string|null}>
     */
    private function fetch(): array
    {
        try {
            $response = Http::timeout(3)->connectTimeout(2)->get(self::FEED_URL);
        } catch (Throwable) {
            return [];
        }

        if (! $response->successful()) {
            return [];
        }

        return $this->parse($response->body());
    }

    /**
     * @return list<array{title: string, url: string, publishedOn: string|null}>
     */
    private function parse(string $xml): array
    {
        $previous = libxml_use_internal_errors(true);
        $feed = simplexml_load_string($xml, options: LIBXML_NONET | LIBXML_NOCDATA);
        libxml_clear_errors();
        libxml_use_internal_errors($previous);

        if ($feed === false || ! isset($feed->channel->item)) {
            return [];
        }

        $insights = [];

        foreach ($feed->channel->item as $item) {
            $title = trim((string) $item->title);
            $url = trim((string) $item->link);

            // Only link to posts on the blog itself.
            if ($title === '' || ! str_starts_with($url, self::BLOG_URL.'/')) {
                continue;
            }

            $insights[] = ['title' => $title, 'url' => $url, 'publishedOn' => $this->date((string) $item->pubDate)];
        }

        usort($insights, fn (array $a, array $b) => strcmp((string) $b['publishedOn'], (string) $a['publishedOn']));

        return $insights;
    }

    private function date(string $pubDate): ?string
    {
        try {
            return $pubDate === '' ? null : CarbonImmutable::parse($pubDate)->utc()->toDateString();
        } catch (Throwable) {
            return null;
        }
    }
}
