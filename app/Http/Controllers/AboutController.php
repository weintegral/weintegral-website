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

    public function aboutAction(): View
    {
        $data = $this->basicContactData;

        return view('about/index', $data);
    }

    public function clientsAction(): View
    {
        $data = $this->basicContactData;

        return view('about/clients', $data);
    }

    public function industriesAction(): View
    {
        $data = $this->basicContactData;

        return view('about/industries', $data);
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
