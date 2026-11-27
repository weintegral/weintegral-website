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
            'seo' => self::seo(
                'Who We Are',
                'WeIntegral builds, tests, deploys and supports business applications and staffs IT roles, from offices in Lakeway, Texas and Ongole, India.',
            ),
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
        return Inertia::render('industries', [
            'seo' => self::seo(
                'Industries',
                'The industries WeIntegral serves with application development, support, testing, DevOps and IT staffing, and how sector knowledge speeds up every project.',
            ),
        ]);
    }

    public function termsOfServiceAction(): Response
    {
        return Inertia::render('legal/terms-of-service', [
            'seo' => self::seo(
                'Terms of Service',
                'The Terms of Service for weintegral.com, the website of West East Integral Inc. (WeIntegral), an IT services and staffing firm.',
            ),
            'contactEmail' => $this->contactInfo->getAdminEmailId(),
        ]);
    }

    public function privacyPolicyAction(): Response
    {
        return Inertia::render('legal/privacy-policy', [
            'seo' => self::seo(
                'Privacy Policy',
                'The Privacy Policy for weintegral.com, the website of West East Integral Inc. (WeIntegral), an IT services and staffing firm.',
            ),
            'contactEmail' => $this->contactInfo->getAdminEmailId(),
        ]);
    }
}
