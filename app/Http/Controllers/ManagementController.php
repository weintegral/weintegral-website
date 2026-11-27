<?php

namespace App\Http\Controllers;

use App\Services\ContactInfo;
use Illuminate\View\View;
use Inertia\Inertia;
use Inertia\Response;

class ManagementController extends Controller
{
    private ContactInfo $contactInfo;
    private array $basicContactData;

    public function __construct(ContactInfo $contactInfo)
    {
        $this->contactInfo = $contactInfo;
        $this->basicContactData = [
            'email' => $this->contactInfo->getAdminEmailId(),
            'phone' => $this->contactInfo->getPhoneNumber(),
            'address' => $this->contactInfo->getCorporateAddress(),
            'executiveOfficeAddress' => $this->contactInfo->getExecutiveAddress(),
            'overseasOfficeAddress' => $this->contactInfo->getOverseasAddress()
        ];
    }

    public function teamAction(): View
    {
        $data = $this->basicContactData;
        return view('management/team', $data);
    }

    public function contactAction(): Response
    {
        return Inertia::render('contact', [
            'contactDetails' => [
                'email' => $this->contactInfo->getAdminEmailId(),
                'phone' => $this->contactInfo->getPhoneNumber(),
            ],
            'offices' => [
                ['name' => 'Corporate Address', 'addressLines' => $this->contactInfo->addressLines($this->contactInfo->getCorporateAddress())],
                ['name' => 'Executive Office', 'addressLines' => $this->contactInfo->addressLines($this->contactInfo->getExecutiveAddress())],
                ['name' => 'Overseas Office', 'addressLines' => $this->contactInfo->addressLines($this->contactInfo->getOverseasAddress())],
            ],
            'visitorRequestUrl' => route('createCustomerRequest', absolute: false),
        ]);
    }
}
