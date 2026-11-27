<?php

namespace App\Http\Controllers;

use App\Services\Resource;
use Inertia\Inertia;
use Inertia\Response;

class ResourceController extends Controller
{
    public function __construct(private readonly Resource $resource)
    {
    }

    /** Candidate Resources: the public visa and H-1B links. */
    public function indexAction(): Response
    {
        return Inertia::render('candidate-resources', [
            'seo' => self::seo(
                'Candidate Resources',
                'Useful links for IT candidates: USCIS case status, H-1B prevailing wages and registration, visa appointment wait times, PERM, E-Verify and OPT extensions.',
            ),
            'candidateResources' => $this->resource->getResources(),
        ]);
    }
}
