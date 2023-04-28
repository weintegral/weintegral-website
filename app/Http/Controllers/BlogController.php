<?php

namespace App\Http\Controllers;

use App\Services\ContactInfo;
use Illuminate\View\View;

class BlogController extends Controller
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

    public function indexAction(): View
    {
        $data = $this->basicContactData;

        return view('blog/index', $data);
    }

    public function singleArticleAction(): View
    {
        $data = $this->basicContactData;

        return view('blog/index', $data);
    }
}
