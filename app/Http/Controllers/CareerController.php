<?php

namespace App\Http\Controllers;

use App\Services\ContactInfo;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CareerController extends Controller
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
    public function indexAction(): View
    {
        $data = $this->basicContactData;
        return view('career/index', $data);
    }

    public function cultureAction(): View
    {
        $data = $this->basicContactData;
        return view('maintenance/pageUnderConstruction', $data);
    }

    public function benefitsAction(): View
    {
        $data = $this->basicContactData;
        return view('maintenance/pageUnderConstruction', $data);
    }

    public function jobOpeningsAction(): View
    {
        $data = $this->basicContactData;
        return view('maintenance/pageUnderConstruction', $data);
    }
}
