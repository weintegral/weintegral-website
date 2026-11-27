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
            'services' => $this->catalog->summaries(),
        ]);
    }

    public function showAction(string $service): Response
    {
        return Inertia::render('services/show', [
            'service' => $this->catalog->page($service),
        ]);
    }
}
