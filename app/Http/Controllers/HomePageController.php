<?php

namespace App\Http\Controllers;

use App\Services\ContactInfo;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HomePageController extends Controller
{
    private ContactInfo $contactInfo;
    private $basicContactData;
    public function __construct(ContactInfo $contactInfo)
    {
        $this->contactInfo = $contactInfo;
        $this->basicContactData = [
            'email' => $this->contactInfo->getEmailId(),
            'phone' => $this->contactInfo->getPhoneNumber(),
            'address' => $this->contactInfo->getAddress()
        ];
    }

    public function indexAction(): View
    {
        $data = $this->basicContactData;

        return view('homePage/index', $data);
    }
}
