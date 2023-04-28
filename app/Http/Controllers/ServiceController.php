<?php

namespace App\Http\Controllers;

use App\Services\ContactInfo;
use Illuminate\View\View;

class ServiceController extends Controller
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

    public function appDevelopmentAction(): View
    {
        $data = $this->basicContactData;

        return view('services/appDevelopment/index', $data);
    }

    public function appSupportAction(): View
    {
        $data = $this->basicContactData;

        return view('services/appSupport/index', $data);
    }

    public function testingAction(): View
    {
        $data = $this->basicContactData;

        return view('services/testing/index', $data);
    }

    public function devopsAction(): View
    {
        $data = $this->basicContactData;

        return view('services/devops/index', $data);
    }

    public function staffingAction(): View
    {
        $data = $this->basicContactData;

        return view('services/staffing/index', $data);
    }
}
