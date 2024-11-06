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

    public function getGoogleGroups(): array
    {
        return [
            [
                'name' => 'PHP Job Group',
                'email' => 'jobs-php@weintegral.com',
                'tech' => 'PHP, Laravel, Symfony, Drupal, Wordpress, Magento, Joomla, CodeIgniter, CakePHP, Zend, Yii, Slim, Lumen, Phalcon, FuelPHP, PHPixie'
            ],
            [
                'name' => 'FrontEnd Job Group',
                'email' => 'jobs-frontend@weintegral.com',
                'tech' => 'HTML, CSS, JavaScript, Angular, React, Vue, Ember, Backbone, Svelte, Next, Nuxt, Gatsby, SvelteKit, Alpine, Remix'
            ],
            [
                'name' => '.NET Job Group',
                'email' => 'jobs-dotnet@weintegral.com',
                'tech' => 'C#, VB.NET, ASP.NET, .NET Core, .NET Framework, Xamarin, Blazor, Razor, WPF, WinForms, UWP, MAUI, Uno, Avalonia'
            ],
            [
                'name' => 'Java Job Group',
                'email' => 'jobs-java@weintegral.com',
                'tech' => 'java, Spring, Hibernate, Struts, JSP, Servlets, JSF, JPA, EJB, JMS, JAX-RS, JAX-WS, JAX-RPC, JAX-R'
            ],
            [
                'name' => 'Business/Data Analyst Job Group',
                'email' => 'jobs-ba@weintegral.com',
                'tech' => 'SQl, Excel, PowerBI, Tableau, Qlik, Looker, Domo, Sisense, Alteryx, Talend, Informatica, SSIS, SSRS, SSAS'
            ],
            [
                'name' => 'DevOps Job Group',
                'email' => 'jobs-devops@weintegral.com',
                'tech' => 'Cloud, AWS, Azure, GCP, Docker, Kubernetes, Jenkins, GitLab, GitHub, BitBucket, CircleCI, TravisCI, TeamCity, Bamboo'
            ],
            [
                'name' => 'Node.js Job Group',
                'email' => 'jobs-nodejs@weintegral.com',
                'tech' => 'Node.js, Express, Koa, Hapi, Sails, Meteor, Nest, Loopback, Adonis, Strapi, Feathers, Total.js, Derby, Socket.io'
            ],
            [
                'name' => 'Automation Job Group',
                'email' => 'jobs-sdet@weintegral.com',
                'tech' => 'Selenuim, Cypress, Puppeteer, TestCafe, WebdriverIO, Protractor, Appium, JUnit, TestNG, JBehave, Cucumber, SpecFlow'
            ]
        ];
    }
}
