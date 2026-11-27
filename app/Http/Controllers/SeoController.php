<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;

/**
 * Crawler-facing files: the XML sitemap of public pages and robots.txt.
 */
class SeoController extends Controller
{
    /**
     * Route names of every public page. Internal Tools, the dropped Clients
     * page and redirect-only paths (/blog, /apps) are deliberately absent.
     */
    private const PUBLIC_PAGE_ROUTES = [
        'homePage',
        'aboutCompanyPage',
        'servicesPage',
        'appDevelopmentPage',
        'appSupportPage',
        'testingPage',
        'devopsPage',
        'staffingPage',
        'industriesPage',
        'teamPage',
        'contactPage',
        'careerIndexPage',
        'workCulturePage',
        'benefitsPage',
        'jobOpeningsPage',
        'resourcePage',
        'termsOfServicePage',
        'privacyPolicyPage',
    ];

    public function sitemapAction(): Response
    {
        $urls = array_map(fn (string $name) => route($name), self::PUBLIC_PAGE_ROUTES);

        return response()
            ->view('seo.sitemap', ['urls' => $urls])
            ->header('Content-Type', 'application/xml; charset=UTF-8');
    }

    public function robotsAction(): Response
    {
        // Internal Tools are not disallowed: crawlers must be able to fetch them
        // to see their noindex directive. They are left out of the sitemap instead.
        $lines = [
            'User-agent: *',
            'Disallow:',
            '',
            'Sitemap: '.route('sitemap'),
        ];

        return response(implode("\n", $lines)."\n")
            ->header('Content-Type', 'text/plain; charset=UTF-8');
    }
}
