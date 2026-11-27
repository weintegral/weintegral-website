<?php

namespace Tests\Feature;

use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

/**
 * Search engines discover the public pages through /sitemap.xml and /robots.txt.
 * Internal Tools and redirect-only paths stay out of the sitemap.
 */
class SitemapTest extends TestCase
{
    /**
     * @return array<string, array{string}>
     */
    public static function publicPaths(): array
    {
        return [
            'home' => ['/'],
            'about' => ['/about'],
            'services' => ['/services'],
            'application development' => ['/app-development'],
            'application support' => ['/app-support'],
            'quality assurance and testing' => ['/testing'],
            'devops and cloud' => ['/devops'],
            'it staffing' => ['/staffing'],
            'industries' => ['/industries'],
            'leadership' => ['/team'],
            'contact' => ['/contact'],
            'careers' => ['/career'],
            'culture' => ['/career/work-culture'],
            'benefits' => ['/career/benefits'],
            'open positions' => ['/career/openings'],
            'candidate resources' => ['/resources'],
            'terms of service' => ['/terms-of-service'],
            'privacy policy' => ['/privacy-policy'],
        ];
    }

    /**
     * Internal Tools, the dropped Clients page and redirect-only paths.
     *
     * @return array<string, array{string}>
     */
    public static function excludedPaths(): array
    {
        return [
            'company systems' => ['/mgmt-resources'],
            'vendors' => ['/vendors'],
            'job portals' => ['/job-portals'],
            'client list' => ['/client-list'],
            'job groups' => ['/job-groups'],
            'marketing submissions' => ['/marketing-data'],
            'marketing data' => ['/data'],
            'clients' => ['/clients'],
            'blog redirect' => ['/blog'],
            'apps redirect' => ['/apps'],
        ];
    }

    public function test_sitemap_is_served_as_xml(): void
    {
        $response = $this->get('/sitemap.xml');

        $response->assertOk();
        $this->assertStringStartsWith('application/xml', $response->headers->get('Content-Type'));

        $xml = simplexml_load_string($response->getContent());
        $this->assertNotFalse($xml, 'The sitemap is well-formed XML.');
        $this->assertSame('urlset', $xml->getName());
        $this->assertSame('http://www.sitemaps.org/schemas/sitemap/0.9', $xml->getNamespaces()['']);
    }

    #[DataProvider('publicPaths')]
    public function test_sitemap_lists_public_page(string $path): void
    {
        $this->assertContains(url($path), $this->sitemapLocations());
    }

    #[DataProvider('excludedPaths')]
    public function test_sitemap_omits_non_public_path(string $path): void
    {
        $this->assertNotContains(url($path), $this->sitemapLocations());
    }

    public function test_sitemap_lists_only_public_pages(): void
    {
        $this->assertCount(count(self::publicPaths()), $this->sitemapLocations());
    }

    public function test_robots_allows_crawling_and_points_to_the_sitemap(): void
    {
        $response = $this->get('/robots.txt');

        $response->assertOk();
        $this->assertStringStartsWith('text/plain', $response->headers->get('Content-Type'));
        $response->assertSee('User-agent: *', escape: false);
        $response->assertSee('Sitemap: '.url('/sitemap.xml'), escape: false);
        $response->assertDontSee('Disallow: /'."\n", escape: false);
    }

    /**
     * @return list<string>
     */
    private function sitemapLocations(): array
    {
        $xml = simplexml_load_string($this->get('/sitemap.xml')->getContent());
        $xml->registerXPathNamespace('s', 'http://www.sitemaps.org/schemas/sitemap/0.9');

        return array_map('strval', $xml->xpath('//s:url/s:loc'));
    }
}
