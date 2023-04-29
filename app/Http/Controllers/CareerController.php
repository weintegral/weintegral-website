<?php

namespace App\Http\Controllers;

use App\Services\ContactInfo;
use App\Services\JobOpportunity;
use Illuminate\View\View;

class CareerController extends Controller
{
    private ContactInfo $contactInfo;

    private array $basicContactData;

    private JobOpportunity $jobOpportunity;

    public function __construct(ContactInfo $contactInfo, JobOpportunity $jobOpportunity)
    {
        $this->contactInfo = $contactInfo;
        $this->basicContactData = [
            'email' => $this->contactInfo->getAdminEmailId(),
            'phone' => $this->contactInfo->getPhoneNumber(),
            'address' => $this->contactInfo->getCorporateAddress()
        ];
        $this->jobOpportunity = $jobOpportunity;
    }

    public function indexAction(): View
    {
        $jobOpenings = ['jobs' => $this->jobOpportunity->getLatestRequirements()];
        $data = array_merge_recursive($this->basicContactData, $jobOpenings);

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
