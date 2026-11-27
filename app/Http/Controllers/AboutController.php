<?php

namespace App\Http\Controllers;

use App\Services\ContactInfo;
use Illuminate\View\View;
use Inertia\Inertia;
use Inertia\Response;

class AboutController extends Controller
{
    private ContactInfo $contactInfo;
    private array $basicContactData;

    public function __construct(ContactInfo $contactInfo)
    {
        $this->contactInfo = $contactInfo;
        $this->basicContactData = [
            'email' => $this->contactInfo->getAdminEmailId(),
            'phone' => $this->contactInfo->getPhoneNumber(),
            'address' => $this->contactInfo->getCorporateAddress()
        ];
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

    public function servicesAction(): View
    {
        $data = $this->basicContactData;

        return view('about/services', $data);
    }

    /**
     * Industries. The names come from the previous Industries page, which was
     * otherwise lorem ipsum: each awaits owner confirmation and a one-line
     * summary (null until supplied).
     */
    public function industriesAction(): Response
    {
        return Inertia::render('industries', [
            'industries' => [
                ['name' => 'Banking', 'summary' => null],
                ['name' => 'Insurance', 'summary' => null],
                ['name' => 'Ecommerce', 'summary' => null],
            ],
        ]);
    }

    public function termsOfServiceAction(): View
    {
        $data = $this->basicContactData;

        return view('about/termsOfService/index', $data);
    }

    public function privacyPolicyAction(): View
    {
        $data = $this->basicContactData;

        return view('about/privacyPolicy/index', $data);
    }
}
