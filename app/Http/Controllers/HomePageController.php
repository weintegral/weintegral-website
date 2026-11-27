<?php

namespace App\Http\Controllers;

use App\Content\SampleContent;
use App\Services\BlogFeed;
use Inertia\Inertia;
use Inertia\Response;

class HomePageController extends Controller
{
    /**
     * Figures from the old About page. Unconfirmed: the page shows them only
     * beside a visible "to confirm" marker (launch checklist).
     */
    private const STATISTICS = [
        ['value' => '110', 'label' => 'Clients served'],
        ['value' => '150', 'label' => 'Projects delivered'],
        ['value' => '1,463', 'label' => 'Hours of support'],
        ['value' => '25', 'label' => 'Employees'],
    ];

    public function __construct(
        private readonly BlogFeed $blogFeed,
        private readonly SampleContent $sampleContent,
    ) {
    }

    public function indexAction(): Response
    {
        return Inertia::render('home', [
            'seo' => self::seo(
                'IT Services and IT Staffing',
                'WeIntegral builds, tests, deploys and supports web and mobile applications, and supplies IT specialists to extend your team. Talk to an Expert today.',
            ),
            'statistics' => $this->sampleContent->statistics() ?? self::STATISTICS,
            // Real testimonials with written consent only; the old site's are template placeholders.
            'testimonials' => $this->sampleContent->testimonials() ?? [],
            'insights' => $this->blogFeed->latestInsights() ?: ($this->sampleContent->insights() ?? []),
            // Sample copy for the page's own gaps; null (placeholders shown) unless sample content is on.
            'sample' => $this->sampleContent->home(),
        ]);
    }
}
