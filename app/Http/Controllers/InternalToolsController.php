<?php

namespace App\Http\Controllers;

use App\Services\Job;
use App\Services\Resource;
use Inertia\Inertia;
use Inertia\Response;

/**
 * Internal Tools: pages that link WeIntegral staff to company systems and
 * recruiting lists. Served with noindex and kept out of navigation and the sitemap.
 */
class InternalToolsController extends Controller
{
    public function __construct(private readonly Job $jobService, private readonly Resource $resource)
    {
    }

    public function managementResourcesAction(): Response
    {
        return Inertia::render('internal-tools/management-resources', [
            'resources' => $this->resource->getManagementResources(),
        ]);
    }

    public function vendorsAction(): Response
    {
        return Inertia::render('internal-tools/vendors', [
            'vendors' => $this->jobService->getVendors(),
        ]);
    }

    public function jobPortalsAction(): Response
    {
        return Inertia::render('internal-tools/job-portals', [
            'jobPortals' => $this->jobService->getJobPortals(),
        ]);
    }

    public function clientListAction(): Response
    {
        return Inertia::render('internal-tools/client-list', [
            'clients' => $this->jobService->getClients(),
        ]);
    }

    public function jobGroupsAction(): Response
    {
        $jobGroups = array_map(fn (array $group) => [
            'name' => $group['name'],
            'email' => $group['email'],
            'technologies' => array_map('trim', explode(',', $group['tech'])),
        ], $this->jobService->getGoogleGroups());

        return Inertia::render('internal-tools/job-groups', ['jobGroups' => $jobGroups]);
    }

    public function marketingSubmissionsAction(): Response
    {
        return Inertia::render('internal-tools/marketing-submissions', [
            'chartUrl' => 'https://docs.google.com/spreadsheets/d/e/2PACX-1vQD--45vQupz7V4wLSps4ZKVrOzFjDO5PQIVxMo9SIhIuiLadq3EuY-vk_x7Vu5RcoCNx_UDFdM7fEk/pubchart?oid=1328419568&format=interactive',
        ]);
    }

    /**
     * The old page showed a DataTables demo table (sample names and salaries),
     * not WeIntegral data, so it now shows an empty state.
     */
    public function marketingDataAction(): Response
    {
        return Inertia::render('internal-tools/marketing-data', [
            'marketingSubmissionsUrl' => route('marketingSubmissionPage', absolute: false),
        ]);
    }
}
