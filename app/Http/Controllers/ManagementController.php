<?php

namespace App\Http\Controllers;

use App\Services\ContactInfo;
use Illuminate\View\View;

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

    public function contactAction(): View
    {
        $data = $this->basicContactData;
        return view('management/contact', $data);
    }
}
