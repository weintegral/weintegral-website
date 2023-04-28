<?php

namespace App\Http\Controllers;

use App\Services\ContactInfo;
use Illuminate\View\View;

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

    public function servicesAction(): View
    {
        $data = $this->basicContactData;

        return view('about/services', $data);
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
