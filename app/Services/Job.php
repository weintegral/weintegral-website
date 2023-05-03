<?php

namespace App\Services;

class Job
{
    public function getLatestRequirements(): array
    {
        return  [
            [
                'id' => 'job-2023042901',
                'primaryTechnology' => 'PHP',
                'role' => 'Backend Developer',
                'brief' => 'PHP Engineer with Laravel, Docker & AWS experience',
                'jobDescription' => '<ul><li>PHP</li><li>SQL</li><li>Laravel</li></ul>',
            ],
            [
                'id' => 'job-2023042902',
                'primaryTechnology' => 'NODEJS',
                'role' => 'API Developer',
                'brief' => 'Node.js Engineer with Express, Docker & AWS experience',
                'jobDescription' => '<ul><li>Node.js</li><li>SQL</li><li>Express.js</li></ul>',
            ],
            [
                'id' => 'job-2023042903',
                'primaryTechnology' => 'PHP',
                'role' => 'Backend Developer',
                'brief' => 'PHP Engineer with Laravel, Docker & AWS experience',
                'jobDescription' => '<ul><li>PHP</li><li>SQL</li><li>Laravel</li></ul>',
            ],
            [
                'id' => 'job-2023042904',
                'primaryTechnology' => 'PHP',
                'role' => 'Backend Developer',
                'brief' => 'PHP Engineer with Laravel, Docker & AWS experience',
                'jobDescription' => '<ul><li>PHP</li><li>SQL</li><li>Laravel</li></ul>',
            ],
            [
                'id' => 'job-2023042905',
                'primaryTechnology' => 'NODEJS',
                'role' => 'API Developer',
                'brief' => 'Node.js Engineer with Express, Docker & AWS experience',
                'jobDescription' => '<ul><li>Node.js</li><li>SQL</li><li>Express.js</li></ul>',
            ],
            [
                'id' => 'job-2023042906',
                'primaryTechnology' => 'PHP',
                'role' => 'Backend Developer',
                'brief' => 'PHP Engineer with Laravel, Docker & AWS experience',
                'jobDescription' => '<ul><li>PHP</li><li>SQL</li><li>Laravel</li></ul>',
            ],
            [
                'id' => 'job-2023042907',
                'primaryTechnology' => 'PHP',
                'role' => 'Backend Developer',
                'brief' => 'PHP Engineer with Laravel, Docker & AWS experience',
                'jobDescription' => '<ul><li>PHP</li><li>SQL</li><li>Laravel</li></ul>',
            ],
            [
                'id' => 'job-2023042908',
                'primaryTechnology' => 'NODEJS',
                'role' => 'API Developer',
                'brief' => 'Node.js Engineer with Express, Docker & AWS experience',
                'jobDescription' => '<ul><li>Node.js</li><li>SQL</li><li>Express.js</li></ul>',
            ],
            [
                'id' => 'job-2023042909',
                'primaryTechnology' => 'SQL',
                'role' => 'Database Admin',
                'brief' => 'SQL Engineer with MySQL, Postgres & AWS experience',
                'jobDescription' => '<ul><li>Postgres</li><li>SQL</li><li>MySQL</li></ul>',
            ]
        ];
    }

    public function getVendors(): array
    {
        return   [
            [
                'name' => 'TEK Systems',
                'url' => 'https://careers.teksystems.com/us/en',
                'verified' => false
            ],
            [
                'name' => 'Judge Group',
                'url' => 'https://www.judge.com/jobs/',
                'verified' => false
            ],
            [
                'name' => 'Beacon Hill Staffing',
                'url' => 'https://jobs.beaconhillstaffing.com/',
                'verified' => false
            ],
            [
                'name' => 'Insight Global',
                'url' => 'https://jobs.insightglobal.com/',
                'verified' => false
            ],
            [
                'name' => 'Pyramid Consulting',
                'url' => 'https://pyramidci.jobs.net/jobs',
                'verified' => false
            ],
            [
                'name' => 'Robert Half',
                'url' => 'https://www.roberthalf.com/looking-for-a-job',
                'verified' => false
            ],
            [
                'name' => 'Value Momentum',
                'url' => 'https://valuemomentum.com/careers/',
                'verified' => false
            ],
            [
                'name' => 'Webject Systems',
                'url' => 'https://webject.com/careers',
                'verified' => true
            ],
            [
                'name' => 'Randstad',
                'url' => 'https://www.randstadusa.com/job-seeker/',
                'verified' => false
            ],
            [
                'name' => 'Max Eleven',
                'url' => 'https://www.maxeleven.com/job-seekers.php',
                'verified' => false
            ],
            [
                'name' => 'Accenture',
                'url' => 'https://www.accenture.com/us-en/careers/jobsearch',
                'verified' => false
            ],
            [
                'name' => 'Cognizant',
                'url' => 'https://careers.cognizant.com/global/en/c/consulting-jobs',
                'verified' => false
            ],
            [
                'name' => 'TCS',
                'url' => 'https://ibegin.tcs.com/iBegin/jobs/search',
                'verified' => false
            ],
            [
                'name' => 'Capgemini',
                'url' => 'https://www.capgemini.com/us-en/join-us/#country_code=us-en',
                'verified' => false
            ],
            [
                'name' => 'Wipro',
                'url' => 'https://careers.wipro.com/careers-home/jobs',
                'verified' => false
            ],
            [
                'name' => 'IBM',
                'url' => 'https://www.ibm.com/careers/us-en/',
                'verified' => false
            ],
            [
                'name' => 'Genpact',
                'url' => 'https://www.genpact.com/careers',
                'verified' => false
            ],
            [
                'name' => 'Deloitte',
                'url' => 'https://apply.deloitte.com/careers/',
                'verified' => false
            ]
        ];
    }

    public function getJobPortals(): array
    {
        return [];
    }

    public function getClients(): array
    {
        return [];
    }
}
