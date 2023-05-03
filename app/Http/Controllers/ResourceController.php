<?php

namespace App\Http\Controllers;

use App\Services\ContactInfo;
use Illuminate\View\View;

class ResourceController extends Controller
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
        $resources = [
            'resources' => [
                [
                    'title' => 'USCIS Case Status Online',
                    'brief' => 'Track the status of an immigration application, petition, or request',
                    'url' => 'https://egov.uscis.gov/casestatus/landing.do'
                ],
                [
                    'title' => 'H1B Prevailing Wages',
                    'brief' => 'Find H1B Prevailing Wage Levels',
                    'url' => 'https://h1bgrader.com/h1b-prevailing-wage'
                ],
                [
                    'title' => 'H1B Visa Salary Database',
                    'brief' => 'Disclosure data from the United States Department of Labor (DOL)',
                    'url' => 'https://h1bdata.info/index.php'
                ],
                [
                    'title' => 'H1B Visa for Indians',
                    'brief' => 'H1B Visa Approvals/ Issuances in India and for Individuals with India Nationality',
                    'url' => 'https://visagrader.com/visa-approvals-and-refusals/H1B/india-ind'
                ],
                [
                    'title' => 'Visa Appointments',
                    'brief' => 'Current US Visa Appointments/ Slots Availability in India',
                    'url' => 'https://visagrader.com/us-visa-time-slots-availability/india-ind'
                ],
                [
                    'title' => 'Current Visa Appointment Wait Times',
                    'brief' => 'Current US Visa Appointment wait times in India',
                    'url' => 'https://visagrader.com/us-visa-appointment-wait-times/india-ind'
                ],
                [
                    'title' => 'Green Card Sponsors',
                    'brief' => 'Green Card Sponsorship Data',
                    'url' => 'https://h1bgrader.com/green-card/sponsors'
                ],
                [
                    'title' => 'PERM Search',
                    'brief' => 'PERM Labor Certification Search',
                    'url' => 'https://h1bgrader.com/green-card/perm-lc-search'
                ],
                [
                    'title' => 'E-VERIFY Data',
                    'brief' => 'Find Participating Employers in E-Verify',
                    'url' => 'https://www.e-verify.gov/about-e-verify/e-verify-data/how-to-find-participating-employers'
                ],
                [
                    'title' => 'Law Bench',
                    'brief' => 'Q&A with Immigration Lawyers',
                    'url' => 'https://www.lawbench.com'
                ],
                [
                    'title' => 'H-1B Electronic Registration',
                    'brief' => 'H-1B Electronic Registration Process',
                    'url' => 'https://www.uscis.gov/working-in-the-united-states/temporary-workers/h-1b-specialty-occupations-and-fashion-models/h-1b-electronic-registration-process'
                ],
                [
                    'title' => 'Extension of OPT',
                    'brief' => 'Extension of Post Completion Optional Practical Training (OPT)',
                    'url' => 'https://www.uscis.gov/working-in-the-united-states/temporary-workers/h-1b-specialty-occupations-and-fashion-models/extension-of-post-completion-optional-practical-training-opt-and-f-1-status-for-eligible-students'
                ]
            ]
        ];

        $data = array_merge_recursive($this->basicContactData, $resources);

        return view('resources/index', $data);
    }
}
