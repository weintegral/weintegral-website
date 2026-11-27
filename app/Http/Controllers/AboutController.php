<?php

namespace App\Http\Controllers;

use App\Services\ContactInfo;
use Inertia\Inertia;
use Inertia\Response;

class AboutController extends Controller
{
    public function __construct(private readonly ContactInfo $contactInfo)
    {
    }

    /**
     * Who We Are. The statistics come from the previous About page and are
     * shown marked "to confirm" until the owner confirms them (launch checklist).
     */
    public function aboutAction(): Response
    {
        return Inertia::render('about', [
            'stats' => [
                ['value' => '110', 'label' => 'Clients served'],
                ['value' => '150', 'label' => 'Projects delivered'],
                ['value' => '1,463', 'label' => 'Hours of support'],
                ['value' => '25', 'label' => 'Employees'],
            ],
        ]);
    }

    /**
     * Industries. The page lists the shared `site.industries` (App\Content\IndustryCatalog).
     */
    public function industriesAction(): Response
    {
        return Inertia::render('industries');
    }

    public function termsOfServiceAction(): Response
    {
        return Inertia::render('legal/terms-of-service', [
            'contactEmail' => $this->contactInfo->getAdminEmailId(),
        ]);
    }

    public function privacyPolicyAction(): Response
    {
        return Inertia::render('legal/privacy-policy', [
            'contactEmail' => $this->contactInfo->getAdminEmailId(),
        ]);
    }
}
