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
            'candidateResources' => $this->resource->getResources(),
        ]);
    }
}
