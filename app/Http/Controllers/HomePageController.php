<?php

namespace App\Http\Controllers;

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

    public function __construct(private readonly BlogFeed $blogFeed)
    {
    }

    public function indexAction(): Response
    {
        return Inertia::render('home', [
            'statistics' => self::STATISTICS,
            // Real testimonials with written consent only; the old site's are template placeholders.
            'testimonials' => [],
            'insights' => $this->blogFeed->latestInsights(),
        ]);
    }
}
