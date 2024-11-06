<?php

namespace App\Http\Controllers;

use App\Services\ContactInfo;
use App\Services\Job;
use App\Services\Resource;
use Illuminate\View\View;

class ResourceController extends Controller
{
    private ContactInfo $contactInfo;
    private Job $jobService;
    private Resource $resource;
    private array $basicContactData;

    public function __construct(ContactInfo $contactInfo, Job $jobService, Resource $resource)
    {
        $this->contactInfo = $contactInfo;
        $this->basicContactData = [
            'email' => $this->contactInfo->getAdminEmailId(),
            'phone' => $this->contactInfo->getPhoneNumber(),
            'address' => $this->contactInfo->getCorporateAddress()
        ];
        $this->jobService = $jobService;
        $this->resource = $resource;
    }

    public function indexAction(): View
    {
        $resources = ['resources' => $this->resource->getResources()];

        $data = array_merge_recursive($this->basicContactData, $resources);

        return view('resources/index', $data);
    }

    public function mgmtAction(): View
    {
        $resources = ['resources' => $this->resource->getManagementResources()];

        $data = array_merge_recursive($this->basicContactData, $resources);

        return view('resources/index', $data);
    }

    public function vendorAction(): View
    {
        $vendors = ['vendors' => $this->jobService->getVendors()];

        $data = array_merge_recursive($this->basicContactData, $vendors);

        return view('resources/vendors/index', $data);
    }

    public function jobPortalAction(): View
    {
        $jobPortals = ['jobPortals' => $this->jobService->getJobPortals()];

        $data = array_merge_recursive($this->basicContactData, $jobPortals);

        return view('resources/jobPortals/index', $data);
    }

    public function clientAction(): View
    {
        $clients = ['clients' => $this->jobService->getClients()];

        $data = array_merge_recursive($this->basicContactData, $clients);

        return view('resources/clients/index', $data);
    }

    public function jobGroupsAction(): View
    {
        $jobGroups = ['jobGroups' => $this->jobService->getGoogleGroups()];

        $data = array_merge_recursive($this->basicContactData, $jobGroups);

        return view('resources/jobGroups/index', $data);
    }
}
