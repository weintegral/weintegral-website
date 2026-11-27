<?php

namespace App\Http\Controllers;

use App\Services\ContactInfo;
use App\Services\Resource;
use Illuminate\View\View;
use Inertia\Inertia;
use Inertia\Response;

class ResourceController extends Controller
{
    private ContactInfo $contactInfo;
    private Resource $resource;
    private array $basicContactData;

    public function __construct(ContactInfo $contactInfo, Resource $resource)
    {
        $this->contactInfo = $contactInfo;
        $this->basicContactData = [
            'email' => $this->contactInfo->getAdminEmailId(),
            'phone' => $this->contactInfo->getPhoneNumber(),
            'address' => $this->contactInfo->getCorporateAddress()
        ];
        $this->resource = $resource;
    }

    /** Candidate Resources: the public visa and H-1B links. */
    public function indexAction(): Response
    {
        return Inertia::render('candidate-resources', [
            'candidateResources' => $this->resource->getResources(),
        ]);
    }
}
