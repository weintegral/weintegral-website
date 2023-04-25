<?php

namespace App\Http\Controllers;

use App\Services\ContactInfo;
use Illuminate\Http\Request;

class AboutController extends Controller
{
    private ContactInfo $contactInfo;
    private $basicContactData;
    public function __construct(ContactInfo $contactInfo)
    {
        $this->contactInfo = $contactInfo;
        $this->basicContactData = [
            'email' => $this->contactInfo->getAdminEmailId(),
            'phone' => $this->contactInfo->getPhoneNumber(),
            'address' => $this->contactInfo->getCorporateAddress()
        ];
    }

    public function aboutAction()
    {
        $data = $this->basicContactData;
        return view('about/index', $data);
    }

    public function servicesAction()
    {
        $data = $this->basicContactData;
        return view('about/services', $data);
    }

    public function clientsAction()
    {
        $data = $this->basicContactData;
        return view('about/clients', $data);
    }

    public function industriesAction()
    {
        $data = $this->basicContactData;
        return view('about/industries', $data);
    }
}
