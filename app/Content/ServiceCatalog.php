<?php

namespace App\Content;

use InvalidArgumentException;

/**
 * The five Services and the content of their pages, owned by Laravel and handed
 * to the shared React page (resources/js/pages/services/show.tsx) as props. It
 * is also the one Services list the whole site shows (listings(), `site.services`).
 *
 * Copy uses only facts from the previous site or supplied by the owner. Anything
 * unconfirmed is a placeholder, ['placeholder' => '...'], which the page renders
 * with the visible placeholder style; every one is listed in the launch checklist.
 * The shape is mirrored by the Service type in resources/js/features/services/service.ts.
 */
class ServiceCatalog
{
    /** Display order, as in the navigation. */
    private const SLUGS = ['app-development', 'app-support', 'testing', 'devops', 'staffing'];

    /**
     * The full content of one Service page, including its related Services.
     *
     * @return array<string, mixed>
     */
    public function page(string $slug): array
    {
        $services = $this->services();

        if (! isset($services[$slug])) {
            throw new InvalidArgumentException("Unknown Service: {$slug}");
        }

        $related = array_values(array_map(
            fn (array $service) => ['name' => $service['name'], 'href' => $service['href']],
            array_filter($services, fn (string $key) => $key !== $slug, ARRAY_FILTER_USE_KEY),
        ));

        return [...$services[$slug], 'relatedServices' => $related];
    }

    /**
     * Every Service as the site shell lists it (header menus, footer, homepage),
     * shared with every page as `site.services`.
     *
     * @return list<array{name: string, href: string, outcome: string}>
     */
    public function listings(): array
    {
        return array_values(array_map(fn (array $service) => [
            'name' => $service['name'],
            'href' => $service['href'],
            'outcome' => $service['outcome'],
        ], $this->services()));
    }

    /**
     * One summary per Service for the Services overview: name, link, outcome and
     * the headings of what the Service delivers.
     *
     * @return list<array{name: string, href: string, outcome: string, highlights: list<string>}>
     */
    public function summaries(): array
    {
        return array_values(array_map(fn (array $service) => [
            'name' => $service['name'],
            'href' => $service['href'],
            'outcome' => $service['outcome'],
            'highlights' => array_column($service['pillars'], 'heading'),
        ], $this->services()));
    }

    /**
     * @return array<string, array<string, mixed>>
     */
    private function services(): array
    {
        $services = [
            'app-development' => $this->applicationDevelopment(),
            'app-support' => $this->applicationSupport(),
            'testing' => $this->qualityAssuranceAndTesting(),
            'devops' => $this->devOpsAndCloud(),
            'staffing' => $this->itStaffing(),
        ];

        foreach (self::SLUGS as $slug) {
            $services[$slug] = [
                'slug' => $slug,
                'href' => '/'.$slug,
                ...$services[$slug],
                'engagementOptions' => self::placeholder(
                    "Which engagement models WeIntegral offers for {$services[$slug]['name']} is awaiting owner confirmation. Planned format: a short comparison of who manages the work, typical duration and best fit."
                ),
                'caseStory' => self::placeholder(
                    "One real {$services[$slug]['name']} engagement in a Challenge, What we did and Result format, published only with the Client's consent."
                ),
            ];
        }

        return $services;
    }

    /**
     * @return array{placeholder: string}
     */
    private static function placeholder(string $text): array
    {
        return ['placeholder' => $text];
    }

    /** The first FAQ on every Service page: how to get started. */
    private static function howToStart(string $what): array
    {
        return [
            'question' => 'How does an engagement start?',
            'answer' => "With a conversation. Tell us about {$what} through the Talk to an Expert form, by email or by phone, and we'll set up a call to understand what you need.",
        ];
    }

    /**
     * @return array<string, mixed>
     */
    private function applicationDevelopment(): array
    {
        return [
            'name' => 'Application Development',
            'outcome' => 'Web and mobile applications built around your process',
            'seo' => [
                'title' => 'Application Development Services',
                'description' => 'Custom web and mobile applications designed around how your business works, tested as they are built and deployed to the cloud by WeIntegral.',
            ],
            'summary' => 'Off-the-shelf software rarely fits how a business works. We design and build web and mobile applications around your process, and take them all the way to production.',
            'atAGlance' => [
                ['term' => 'We build', 'detail' => 'Web applications, mobile applications and the databases behind them'],
                ['term' => 'We ship to', 'detail' => 'The cloud, with testing built into every release'],
                ['term' => 'Pairs with', 'detail' => 'Quality Assurance & Testing, DevOps & Cloud, Application Support'],
                ['term' => 'Engagement', 'detail' => self::placeholder('Models offered, owner to confirm')],
            ],
            'overview' => [
                'heading' => 'Software shaped around your business',
                'paragraphs' => [
                    'Every application we build starts with how your people work today and where you want the business to go. We turn that into clear requirements, then into software your team will actually use.',
                    'Because WeIntegral also tests, deploys and supports applications, the same firm that writes your code can carry it into production and keep it healthy afterwards.',
                ],
            ],
            'pillars' => [
                ['heading' => 'Software that fits your process', 'capabilities' => [
                    'Requirements and discovery sessions',
                    'Web application development',
                    'Mobile application development',
                ]],
                ['heading' => 'Data you can rely on', 'capabilities' => [
                    'Database design',
                    'Database management',
                    self::placeholder('Integration with existing systems, confirm'),
                ]],
                ['heading' => 'A clear path to production', 'capabilities' => [
                    'Testing built into every release',
                    'Cloud deployment',
                    'Handover to Application Support',
                ]],
            ],
            'delivery' => [
                'intro' => 'Four steps across the Discover, Build and Run stages every engagement follows.',
                'steps' => [
                    ['stage' => 'Discover', 'title' => 'Discover', 'description' => 'We map your goals, users and current systems, and agree on scope, team and timeline.'],
                    ['stage' => 'Discover', 'title' => 'Design', 'description' => 'We plan the architecture, data model and screens of your application.'],
                    ['stage' => 'Build', 'title' => 'Build and test', 'description' => 'We develop the application and test it before release.'],
                    ['stage' => 'Run', 'title' => 'Launch and support', 'description' => 'We deploy your application to the cloud and support it after launch.'],
                ],
            ],
            'technologies' => [
                'heading' => 'Technologies',
                'items' => ['PHP and Laravel', 'JavaScript', 'React', 'Angular', 'Vue.js', 'Node.js', 'Java', 'React Native (mobile)'],
                'note' => self::placeholder('List taken from the current Services page; owner to confirm, and add databases'),
            ],
            'faqs' => [
                self::howToStart("what you're building"),
                ['question' => 'Can you also test and support what you build?', 'answer' => 'Yes. Quality Assurance & Testing, DevOps & Cloud and Application Support are all WeIntegral Services, so one firm can carry your application from first release to day-to-day operation.'],
                ['question' => 'Can you work alongside our in-house developers?', 'answer' => self::placeholder('Answer to be supplied by owner')],
                ['question' => 'Who owns the code you write?', 'answer' => self::placeholder('Answer to be supplied by owner (contract terms)')],
            ],
        ];
    }

    /**
     * @return array<string, mixed>
     */
    private function applicationSupport(): array
    {
        return [
            'name' => 'Application Support',
            'outcome' => 'Maintenance and production support for critical systems',
            'seo' => [
                'title' => 'Application Support and Maintenance',
                'description' => 'Application maintenance and production support from WeIntegral that keeps the software your business depends on stable, patched and running.',
            ],
            'summary' => 'Launch is where an application starts its working life. We maintain, fix and improve the applications your business runs on, so your team spends less time on fire drills.',
            'atAGlance' => [
                ['term' => 'We support', 'detail' => 'Web and mobile applications in production'],
                ['term' => 'Coverage', 'detail' => self::placeholder('Support hours and service levels, owner to confirm')],
                ['term' => 'Pairs with', 'detail' => 'Application Development, DevOps & Cloud, Quality Assurance & Testing'],
                ['term' => 'Engagement', 'detail' => self::placeholder('Models offered, owner to confirm')],
            ],
            'overview' => [
                'heading' => 'Stability after launch',
                'paragraphs' => [
                    'Software keeps changing after release: users find defects, libraries need updates and the business asks for small improvements. Support is the steady work that keeps an application healthy through all of it.',
                    self::placeholder('Banking experience: the current site says WeIntegral has provided mission-critical solutions and services to banks worldwide. Owner to confirm before publishing.'),
                ],
            ],
            'pillars' => [
                ['heading' => 'Fewer fire drills', 'capabilities' => [
                    'Production issue diagnosis and fixes',
                    self::placeholder('Root-cause follow-up on recurring issues, confirm'),
                    self::placeholder('Monitoring and alerting, confirm'),
                ]],
                ['heading' => 'Software that stays current', 'capabilities' => [
                    'Framework and dependency updates',
                    'Security patches',
                    'Database maintenance',
                ]],
                ['heading' => 'Room to improve', 'capabilities' => [
                    'Small enhancements your users ask for',
                    'Performance tuning',
                    'Larger changes delivered through Application Development',
                ]],
            ],
            'delivery' => [
                'intro' => 'Four steps across the Discover, Build and Run stages every engagement follows, from first look to ongoing support.',
                'steps' => [
                    ['stage' => 'Discover', 'title' => 'Assess', 'description' => 'We review the application, its environments and known issues, and agree on what support covers.'],
                    ['stage' => 'Build', 'title' => 'Stabilize', 'description' => 'We fix the most urgent defects first.'],
                    ['stage' => 'Run', 'title' => 'Maintain', 'description' => 'We handle fixes, updates and small enhancements to keep the application running.'],
                    ['stage' => 'Run', 'title' => 'Plan ahead', 'description' => 'We plan upcoming fixes and changes with you.'],
                ],
            ],
            'technologies' => [
                'heading' => 'Technologies',
                'items' => [],
                'note' => self::placeholder('Platforms and tools the support team works with, supplied by the owner'),
            ],
            'faqs' => [
                self::howToStart('the application you need supported'),
                ['question' => 'Can you add new features as well as fix issues?', 'answer' => 'Yes. Small enhancements are part of support, and larger changes can move to Application Development, which is also a WeIntegral Service.'],
                ['question' => 'Can you support an application another team built?', 'answer' => self::placeholder('Answer to be supplied by owner')],
                ['question' => 'What hours do you provide support?', 'answer' => self::placeholder('Answer to be supplied by owner (coverage hours and service levels)')],
            ],
        ];
    }

    /**
     * @return array<string, mixed>
     */
    private function qualityAssuranceAndTesting(): array
    {
        return [
            'name' => 'Quality Assurance & Testing',
            'outcome' => 'Testing focused on deployment readiness',
            'seo' => [
                'title' => 'Quality Assurance and Software Testing',
                'description' => 'Software quality assurance from WeIntegral focused on deployment readiness: testing that finds defects before release, for fewer surprises at launch.',
            ],
            'summary' => 'Defects your users find cost more than defects found before release. Our quality assurance work answers one question: is this release ready to deploy?',
            'atAGlance' => [
                ['term' => 'We test', 'detail' => 'Web and mobile applications before each release'],
                ['term' => 'Focus', 'detail' => 'Deployment readiness, quality and performance'],
                ['term' => 'Pairs with', 'detail' => 'Application Development, DevOps & Cloud, Application Support'],
                ['term' => 'Engagement', 'detail' => self::placeholder('Models offered, owner to confirm')],
            ],
            'overview' => [
                'heading' => 'Quality built in, not bolted on',
                'paragraphs' => [
                    'Testing works best when it starts early. We plan what to test alongside the features themselves, so problems surface while they are still cheap to fix.',
                    'The goal is release confidence: knowing an application works and performs as expected before it reaches your users.',
                ],
            ],
            'pillars' => [
                ['heading' => 'Catch defects early', 'capabilities' => [
                    'Test planning alongside each feature',
                    'Functional testing',
                    'Regression testing',
                ]],
                ['heading' => 'Confidence under load', 'capabilities' => [
                    'Performance testing',
                    self::placeholder('Security testing, confirm'),
                    'Release readiness sign-off',
                ]],
                ['heading' => 'Results you can act on', 'capabilities' => [
                    'Clear defect reports your developers can reproduce',
                    'Manual exploratory testing',
                    self::placeholder('Test automation, tools to confirm'),
                ]],
            ],
            'delivery' => [
                'intro' => 'Four steps across the Discover, Build and Run stages every engagement follows, tied to each release.',
                'steps' => [
                    ['stage' => 'Discover', 'title' => 'Plan', 'description' => 'We learn what the application must do and agree on what to test, how, and what "ready" means.'],
                    ['stage' => 'Build', 'title' => 'Test', 'description' => "We test the application's features before release."],
                    ['stage' => 'Build', 'title' => 'Report', 'description' => 'We log each defect with the steps to reproduce it and work with your developers until it is fixed.'],
                    ['stage' => 'Run', 'title' => 'Confirm', 'description' => 'We verify fixes and confirm the release is ready to deploy.'],
                ],
            ],
            'technologies' => [
                'heading' => 'Tools',
                'items' => [],
                'note' => self::placeholder('Testing tools and frameworks the team uses, supplied by the owner'),
            ],
            'faqs' => [
                self::howToStart('the application and release you need tested'),
                ['question' => 'What is the difference between manual and automated testing?', 'answer' => 'Manual testing is a person working through the application the way a user would, which is good at finding unexpected problems. Automated tests are scripts that repeat the same checks on every build, which catches regressions quickly. Most applications benefit from both.'],
                ['question' => 'Can you test software we built ourselves?', 'answer' => self::placeholder('Answer to be supplied by owner')],
                ['question' => 'Which test automation tools do you use?', 'answer' => self::placeholder('Answer to be supplied by owner')],
            ],
        ];
    }

    /**
     * @return array<string, mixed>
     */
    private function devOpsAndCloud(): array
    {
        return [
            'name' => 'DevOps & Cloud',
            'outcome' => 'Pipelines and cloud deployment, commit to production',
            'seo' => [
                'title' => 'DevOps and Cloud Deployment',
                'description' => 'DevOps and cloud services from WeIntegral: build pipelines, automated deployment and cloud environments that move code from commit to production reliably.',
            ],
            'summary' => 'Getting code from a developer to production should be routine, not an event. We set up the pipelines and cloud environments that make every release repeatable.',
            'atAGlance' => [
                ['term' => 'We set up', 'detail' => 'Build and deployment pipelines, and the cloud environments they deploy to'],
                ['term' => 'Cloud platforms', 'detail' => 'Amazon Web Services (AWS), Microsoft Azure and Google Cloud'],
                ['term' => 'Pairs with', 'detail' => 'Application Development, Quality Assurance & Testing, Application Support'],
                ['term' => 'Engagement', 'detail' => self::placeholder('Models offered, owner to confirm')],
            ],
            'overview' => [
                'heading' => 'From commit to production',
                'paragraphs' => [
                    'DevOps brings software development and IT operations together so changes reach production quickly and safely. At its core is continuous integration and continuous delivery (CI/CD): every change is built and tested automatically, then deployed the same way every time.',
                    'Because WeIntegral also builds and tests applications, the pipeline we set up reflects how your software is actually developed.',
                ],
            ],
            'pillars' => [
                ['heading' => 'Releases on repeat', 'capabilities' => [
                    'CI/CD pipelines',
                    'Automated builds and test runs',
                    'Repeatable deployments to every environment',
                ]],
                ['heading' => 'Environments you can rebuild', 'capabilities' => [
                    'Cloud environment setup',
                    self::placeholder('Infrastructure as code (environments defined in versioned files), confirm'),
                    self::placeholder('Migrating existing systems to the cloud, confirm'),
                ]],
                ['heading' => 'Visibility after release', 'capabilities' => [
                    self::placeholder('Monitoring and alerting, tools to confirm'),
                    self::placeholder('Cloud cost reviews, confirm'),
                    'Documentation your team can run with',
                ]],
            ],
            'delivery' => [
                'intro' => 'Four steps across the Discover, Build and Run stages every engagement follows, from manual releases to an automated path to production.',
                'steps' => [
                    ['stage' => 'Discover', 'title' => 'Assess', 'description' => 'We review how code is built, tested and released today, and where it slows down or breaks.'],
                    ['stage' => 'Build', 'title' => 'Automate', 'description' => 'We build the pipeline that compiles, tests and packages every change.'],
                    ['stage' => 'Run', 'title' => 'Deploy', 'description' => 'We set up the cloud environments and automate deployment to each of them.'],
                    ['stage' => 'Run', 'title' => 'Document', 'description' => 'We document the setup so your team can work with it.'],
                ],
            ],
            'technologies' => [
                'heading' => 'Platforms and tools',
                'items' => ['Amazon Web Services (AWS)', 'Microsoft Azure', 'Google Cloud'],
                'note' => self::placeholder('Cloud platforms from the current Services page; owner to confirm, and add CI/CD and infrastructure tools'),
            ],
            'faqs' => [
                self::howToStart('how you build and release software today'),
                ['question' => 'What is CI/CD?', 'answer' => 'Continuous integration (CI) builds and tests every change as soon as it is committed. Continuous delivery (CD) then deploys changes that pass, the same way every time. Together they make releases smaller, more frequent and less risky.'],
                ['question' => 'Which cloud platform should we use?', 'answer' => self::placeholder('Answer to be supplied by owner')],
                ['question' => 'Can you work with our existing infrastructure?', 'answer' => self::placeholder('Answer to be supplied by owner')],
            ],
        ];
    }

    /**
     * @return array<string, mixed>
     */
    private function itStaffing(): array
    {
        return [
            'name' => 'IT Staffing',
            'outcome' => 'Skilled IT professionals for the roles you need',
            'seo' => [
                'title' => 'IT Staffing Services',
                'description' => 'IT staffing from WeIntegral: skilled professionals who join your team for the roles you need to fill, matched to the skills the work requires.',
            ],
            'summary' => 'Some work needs another skilled person on your team rather than a whole project. We find IT professionals with the skills the role needs and the fit your team needs.',
            'atAGlance' => [
                ['term' => 'We serve', 'detail' => 'IT organizations, including multinationals'],
                ['term' => 'Roles', 'detail' => self::placeholder('Typical roles filled, owner to confirm')],
                ['term' => 'Hiring models', 'detail' => self::placeholder('Contract, contract-to-hire or direct hire: owner to confirm which apply')],
                ['term' => 'Pairs with', 'detail' => 'Application Development, Quality Assurance & Testing, DevOps & Cloud'],
            ],
            'overview' => [
                'heading' => 'The people you need, when you need them',
                'paragraphs' => [
                    'Staffing works when the person fits both the work and the team. We start from the role: the skills it needs, how your team works and how long you need help.',
                    'WeIntegral provides staffing services to IT organizations, including multinationals, across many areas of talent acquisition.',
                ],
            ],
            'pillars' => [
                ['heading' => 'Candidates who fit the role', 'capabilities' => [
                    'A briefing on the role and the skills it needs',
                    'Technical screening',
                    'A shortlist of candidates for you to interview',
                ]],
                ['heading' => 'Flexible ways to hire', 'capabilities' => [
                    self::placeholder('Contract staffing, confirm'),
                    self::placeholder('Contract-to-hire, confirm'),
                    self::placeholder('Direct hire, confirm'),
                ]],
                ['heading' => 'Consultants who keep growing', 'capabilities' => [
                    'Growth opportunities for every consultant',
                    'Continuous learning and development',
                    self::placeholder('Replacement policy, owner to supply'),
                ]],
            ],
            'delivery' => [
                'intro' => 'Four steps across the Discover, Build and Run stages every engagement follows, from an open role to a new team member.',
                'steps' => [
                    ['stage' => 'Discover', 'title' => 'Brief', 'description' => 'We learn the role, the skills it needs, your team and your timeline.'],
                    ['stage' => 'Build', 'title' => 'Search and screen', 'description' => 'We find candidates and screen them for the skills the work requires.'],
                    ['stage' => 'Build', 'title' => 'Interview', 'description' => 'You meet a shortlist of candidates and choose who joins your team.'],
                    ['stage' => 'Run', 'title' => 'Start', 'description' => 'We agree on a start date, and your new team member joins your team.'],
                ],
            ],
            'technologies' => [
                'heading' => 'Skills we recruit for',
                'items' => [],
                'note' => self::placeholder('Skills and roles WeIntegral recruits for, supplied by the owner'),
            ],
            'faqs' => [
                self::howToStart('the role you need to fill'),
                ['question' => 'Can you deliver a whole project instead?', 'answer' => "Yes. If you'd rather hand over the work than add people, Application Development, Quality Assurance & Testing, DevOps & Cloud and Application Support are all WeIntegral Services."],
                ['question' => 'How quickly can you present candidates?', 'answer' => self::placeholder('Answer to be supplied by owner (typical turnaround)')],
                ['question' => "What if a placement doesn't work out?", 'answer' => self::placeholder('Answer to be supplied by owner (replacement policy)')],
            ],
        ];
    }
}
