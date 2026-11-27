<?php

namespace App\Http\Controllers;

use App\Services\ContactInfo;
use App\Services\Resource;
use Illuminate\View\View;

class ResourceController extends Controller
{
    private ContactInfo $contactInfo;
    private Resource $resource;
    private array $basicContactData;

    public function __construct(ContactInfo $contactInfo, Resource $resource)
    {
        $this->contactInfo = $contactInfo;
        $this->basicContactData = [
            'email' => $this->contactInfo->getAdminEmailId(),
            'phone' => $this->contactInfo->getPhoneNumber(),
            'address' => $this->contactInfo->getCorporateAddress()
        ];
        $this->resource = $resource;
    }

    public function indexAction(): View
    {
        $resources = ['resources' => $this->resource->getResources()];

        $data = array_merge_recursive($this->basicContactData, $resources);

        return view('resources/index', $data);
    }
}
