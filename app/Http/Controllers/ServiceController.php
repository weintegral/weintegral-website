<?php

namespace App\Http\Controllers;

use App\Content\ServiceCatalog;
use Inertia\Inertia;
use Inertia\Response;

/**
 * The Services overview and the five Service pages. Each Service route passes
 * its slug as the `service` route default; one page component renders them all.
 */
class ServiceController extends Controller
{
    public function __construct(private readonly ServiceCatalog $catalog)
    {
    }

    public function indexAction(): Response
    {
        return Inertia::render('services/index', [
            'seo' => self::seo(
                'IT Services',
                "WeIntegral's IT services: application development, application support, quality assurance and testing, DevOps and cloud, and IT staffing.",
            ),
            'services' => $this->catalog->summaries(),
        ]);
    }

    public function showAction(string $service): Response
    {
        $page = $this->catalog->page($service);

        return Inertia::render('services/show', [
            'seo' => $page['seo'],
            'service' => $page,
        ]);
    }
}
