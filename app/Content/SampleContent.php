<?php

namespace App\Content;

use App\Services\BlogFeed;
use Illuminate\Contracts\Config\Repository as Config;
use Illuminate\Contracts\Foundation\Application;
use InvalidArgumentException;

/**
 * Fictional content for reviewing the complete site locally. Every value here is
 * invented: the people, companies ("Example …"), figures, quotes and policies are
 * samples, not WeIntegral facts, and each stands in for a launch-checklist item.
 *
 * It is the only source of sample values. It is on only when SITE_SAMPLE_CONTENT
 * is true (config `site.sample_content`) and never when APP_ENV is production;
 * while on, every page shows the "Sample content — not for publication" banner.
 * When off, every method that returns page content returns null, so pages keep
 * their visible placeholders.
 */
class SampleContent
{
    public const NOTICE = 'Sample content — not for publication';

    /** Fictional Clients, named only as text (never with a logo). */
    private const CLIENTS = [
        'bank' => 'Example Regional Bank',
        'insurer' => 'Example Insurance Group',
        'retailer' => 'Example Outfitters',
        'health' => 'Example Health Partners',
        'logistics' => 'Example Logistics Co.',
    ];

    /** The engagement models, in the order of the Services overview comparison. */
    private const ENGAGEMENT_MODELS = [
        'project' => [
            'name' => 'Project-based delivery',
            'description' => 'We own an agreed scope and deliverable, with a set team and timeline.',
            'whoManages' => 'WeIntegral',
            'duration' => '2 to 9 months',
            'bestFor' => 'A new application or a defined piece of work',
        ],
        'managed' => [
            'name' => 'Managed support',
            'description' => 'Ongoing support under agreed service levels and a monthly hours allowance.',
            'whoManages' => 'WeIntegral',
            'duration' => '12 months, renewable',
            'bestFor' => 'Applications already in production',
        ],
        'contract' => [
            'name' => 'Contract staffing',
            'description' => 'Screened specialists join your team on your timeline and work under your direction.',
            'whoManages' => 'Your team',
            'duration' => '3 to 12 months',
            'bestFor' => 'Extra capacity or a skill your team lacks',
        ],
        'contract-to-hire' => [
            'name' => 'Contract-to-hire',
            'description' => 'Work with a specialist on contract first, then hire them once you are sure of the fit.',
            'whoManages' => 'Your team',
            'duration' => '3 to 6 months, then permanent',
            'bestFor' => 'Roles where fit matters as much as skills',
        ],
        'direct-hire' => [
            'name' => 'Direct hire',
            'description' => 'We find and screen the candidates; you hire them onto your payroll.',
            'whoManages' => 'Your team',
            'duration' => 'Permanent',
            'bestFor' => 'Long-term roles on your own team',
        ],
    ];

    /** Which engagement models each Service offers. */
    private const SERVICE_ENGAGEMENT_MODELS = [
        'app-development' => ['project', 'contract'],
        'app-support' => ['managed', 'project'],
        'testing' => ['project', 'contract'],
        'devops' => ['project', 'managed'],
        'staffing' => ['contract', 'contract-to-hire', 'direct-hire'],
    ];

    /** Short copy that fills a Service page placeholder, keyed "<service>.<item>". */
    private const SERVICE_COPY = [
        'app-development.engagement' => 'Project-based delivery or contract staffing',
        'app-development.integration' => 'Integration with existing systems',
        'app-development.code-ownership' => 'You do. The code we write for you, and the rights to it, transfer to you as each milestone is paid.',
        'app-support.engagement' => 'Managed support or a one-off stabilization project',
        'app-support.coverage' => '8am to 6pm Central, Monday to Friday, with on-call cover for critical issues',
        'app-support.experience' => 'Our support team looks after applications for regional banks and insurers, including systems that must stay up throughout the business day.',
        'app-support.root-cause' => 'Root-cause follow-up on recurring issues',
        'app-support.monitoring' => 'Monitoring and alerting',
        'app-support.hours' => 'Standard support runs from 8am to 6pm Central Time, Monday to Friday. Critical issues get on-call cover around the clock, with a first response within one hour.',
        'testing.engagement' => 'Per release, or testers who join your team',
        'testing.security' => 'Security testing',
        'testing.automation' => 'Test automation with Playwright and Selenium',
        'testing.automation-tools' => 'Mostly Playwright and Selenium for browser tests, Postman for APIs and JMeter for load tests. We can also work with the tools your team already uses.',
        'devops.engagement' => 'A setup project, then optional managed support',
        'devops.infrastructure-as-code' => 'Infrastructure as code (environments defined in versioned files)',
        'devops.migration' => 'Migrating existing systems to the cloud',
        'devops.monitoring' => 'Monitoring and alerting',
        'devops.cost-reviews' => 'Cloud cost reviews',
        'staffing.roles' => 'Developers, testers, DevOps engineers and database administrators',
        'staffing.hiring-models' => 'Contract, contract-to-hire and direct hire',
        'staffing.contract' => 'Contract staffing',
        'staffing.contract-to-hire' => 'Contract-to-hire',
        'staffing.direct-hire' => 'Direct hire',
        'staffing.replacement' => 'A free replacement within the first 90 days',
        'staffing.turnaround' => 'For common roles, usually within five business days of the role briefing. Specialist roles can take longer, and we tell you up front.',
        'staffing.failed-placement' => "Tell us. If a placement ends within the first 90 days, we find a replacement at no extra fee.",
    ];

    /** Technologies, tools or skills per Service page. */
    private const TECHNOLOGIES = [
        'app-development' => ['PHP and Laravel', 'JavaScript', 'React', 'Angular', 'Vue.js', 'Node.js', 'Java', 'React Native (mobile)', 'MySQL', 'PostgreSQL', 'Microsoft SQL Server'],
        'app-support' => ['Linux and Windows servers', 'MySQL', 'PostgreSQL', 'Jira Service Management', 'Datadog', 'Sentry'],
        'testing' => ['Playwright', 'Selenium', 'Postman', 'Apache JMeter', 'Jira'],
        'devops' => ['Amazon Web Services (AWS)', 'Microsoft Azure', 'Google Cloud', 'GitHub Actions', 'Jenkins', 'Terraform', 'Docker', 'Kubernetes'],
        'staffing' => ['Java', '.NET', 'PHP', 'JavaScript and React', 'Python', 'Test automation', 'DevOps and cloud', 'Database administration'],
    ];

    public function __construct(
        private readonly Config $config,
        private readonly Application $app,
    ) {
    }

    public function enabled(): bool
    {
        return (bool) $this->config->get('site.sample_content') && ! $this->app->environment('production');
    }

    /**
     * What the site shell shows on every page (`site.sample`): the banner text, the
     * closing band's reply-time promise and the footer's social links.
     *
     * @return array{notice: string, replyTime: string, socialLinks: list<array{label: string, href: string}>}|null
     */
    public function shell(): ?array
    {
        return $this->whenEnabled(fn () => [
            'notice' => self::NOTICE,
            'replyTime' => 'We reply within one business day.',
            'socialLinks' => [
                ['label' => 'LinkedIn', 'href' => 'https://www.linkedin.com/company/example'],
                ['label' => 'X', 'href' => 'https://x.com/example'],
                ['label' => 'Facebook', 'href' => 'https://www.facebook.com/example'],
            ],
        ]);
    }

    /**
     * Headline figures for the homepage and Who We Are.
     *
     * @return list<array{value: string, label: string}>|null
     */
    public function statistics(): ?array
    {
        return $this->whenEnabled(fn () => [
            ['value' => '48', 'label' => 'Clients served'],
            ['value' => '120', 'label' => 'Projects delivered'],
            ['value' => '9,600', 'label' => 'Hours of support'],
            ['value' => '32', 'label' => 'Employees'],
        ]);
    }

    /**
     * @return list<array{quote: string, name: string, title: string, company: string}>|null
     */
    public function testimonials(): ?array
    {
        return $this->whenEnabled(fn () => [
            [
                'quote' => 'They took over an application nobody on our side wanted to touch, stabilized it within weeks and have kept improving it since.',
                'name' => 'Jamie Carter',
                'title' => 'VP of Engineering',
                'company' => self::CLIENTS['bank'],
            ],
            [
                'quote' => 'Their testers found the problems our release checklist kept missing. Launch day was quiet for the first time in years.',
                'name' => 'Morgan Ellis',
                'title' => 'Head of Digital',
                'company' => self::CLIENTS['insurer'],
            ],
            [
                'quote' => 'We needed two senior developers within a month. Both are still on the team a year later.',
                'name' => 'Chris Navarro',
                'title' => 'Director of IT',
                'company' => self::CLIENTS['retailer'],
            ],
        ]);
    }

    /**
     * Blog posts shown when the real feed is unavailable.
     *
     * @return list<array{title: string, url: string, publishedOn: string}>|null
     */
    public function insights(): ?array
    {
        return $this->whenEnabled(fn () => [
            ['title' => 'Five questions to ask before you outsource application support', 'url' => BlogFeed::BLOG_URL, 'publishedOn' => '2026-11-12'],
            ['title' => 'What a release-readiness review looks like', 'url' => BlogFeed::BLOG_URL, 'publishedOn' => '2026-10-28'],
            ['title' => 'Contract-to-hire: when to try before you commit', 'url' => BlogFeed::BLOG_URL, 'publishedOn' => '2026-10-07'],
        ]);
    }

    /**
     * Copy for the homepage's own gaps.
     *
     * @return array{officeWork: string}|null
     */
    public function home(): ?array
    {
        return $this->whenEnabled(fn () => [
            'officeWork' => 'Lakeway leads planning with Clients while Ongole builds, tests and supports, so work moves forward across both time zones.',
        ]);
    }

    /**
     * Copy for Who We Are.
     *
     * @return array{foundingStory: string, officeWork: string}|null
     */
    public function about(): ?array
    {
        return $this->whenEnabled(fn () => [
            'foundingStory' => 'WeIntegral started in 2016 with three engineers and one Client, supporting a loan-servicing application. The Lakeway office opened in 2018 and the Ongole team followed in 2020.',
            'officeWork' => 'The Lakeway team leads Client conversations, discovery and planning. The Ongole team builds, tests and supports applications, so work continues while Texas is offline.',
        ]);
    }

    /**
     * Leadership profiles, shown with initials avatars (no photos of real people).
     *
     * @return list<array{name: string, title: string, bio: string, initials: string, photoUrl: null, linkedInUrl: string}>|null
     */
    public function leaders(): ?array
    {
        $leader = fn (string $name, string $initials, string $title, string $bio) => [
            'name' => $name,
            'title' => $title,
            'bio' => $bio,
            'initials' => $initials,
            'photoUrl' => null,
            'linkedInUrl' => 'https://www.linkedin.com/in/example',
        ];

        return $this->whenEnabled(fn () => [
            $leader('Avery Morgan', 'AM', 'Chief Executive Officer', 'Avery founded WeIntegral to give businesses one accountable team for building and running their software. Before that, Avery led delivery teams for banks and insurers for fifteen years.'),
            $leader('Priya Raman', 'PR', 'Head of Delivery', 'Priya runs the engineering and support teams in Ongole and Lakeway. She has shipped and supported business applications for more than twelve years.'),
            $leader('Daniel Ortiz', 'DO', 'Director of Quality Assurance', 'Daniel leads testing across every engagement and built the firm\'s release-readiness review. He started his career as a manual tester and still enjoys finding the bug nobody expected.'),
            $leader('Meera Iyer', 'MI', 'Head of Talent', 'Meera leads recruiting for Clients and for WeIntegral itself. She looks after every consultant from the first interview to their next assignment.'),
        ]);
    }

    /**
     * Copy for the Careers pages: how hiring works and benefit specifics.
     *
     * @return array<string, string>|null
     */
    public function careers(): ?array
    {
        return $this->whenEnabled(fn () => [
            'hiringSteps' => 'A recruiter replies within five business days. Next come a technical conversation and a final interview with the hiring manager.',
            'health' => 'Medical, dental and vision coverage for employees and their families, from the first of the month after you join.',
            'timeOff' => '15 days of paid time off and 10 company holidays each year.',
            'retirement' => 'A 401(k) plan with a 4% employer match.',
            'growth' => 'A $1,500 yearly training and certification budget.',
            'eligibility' => 'Full-time employees and W-2 consultants can join the health plans and the 401(k) from the first of the month after they start. Consultants on corp-to-corp contracts receive benefits through their own employer.',
        ]);
    }

    /**
     * The Services overview: the engagement-model comparison and the pricing answer.
     *
     * @return array{engagementModels: list<array<string, string>>, pricing: string}|null
     */
    public function servicesOverview(): ?array
    {
        return $this->whenEnabled(fn () => [
            'engagementModels' => array_values(array_map(
                fn (array $model) => array_diff_key($model, ['description' => true]),
                self::ENGAGEMENT_MODELS,
            )),
            'pricing' => 'Project-based work is a fixed price per phase, agreed after discovery. Managed support is a monthly fee for an agreed hours allowance. Contract staffing is billed hourly, and direct hire is a one-time fee.',
        ]);
    }

    /**
     * Short copy for one Service page placeholder, keyed "<service>.<item>".
     */
    public function serviceCopy(string $key): string
    {
        return self::SERVICE_COPY[$key] ?? throw new InvalidArgumentException("No sample copy for {$key}");
    }

    /**
     * @return list<string>
     */
    public function technologies(string $slug): array
    {
        return self::TECHNOLOGIES[$slug] ?? throw new InvalidArgumentException("No sample technologies for {$slug}");
    }

    /**
     * The engagement models a Service offers.
     *
     * @return list<array{name: string, description: string}>
     */
    public function engagementOptions(string $slug): array
    {
        $keys = self::SERVICE_ENGAGEMENT_MODELS[$slug] ?? throw new InvalidArgumentException("No sample engagement options for {$slug}");

        return array_map(fn (string $key) => [
            'name' => self::ENGAGEMENT_MODELS[$key]['name'],
            'description' => self::ENGAGEMENT_MODELS[$key]['description'],
        ], $keys);
    }

    /**
     * One case story per Service, in a Challenge, What we did, Result format.
     *
     * @return array{client: string, challenge: string, approach: string, result: string}
     */
    public function caseStory(string $slug): array
    {
        return match ($slug) {
            'app-development' => [
                'client' => self::CLIENTS['retailer'],
                'challenge' => 'Store managers tracked stock transfers in shared spreadsheets, and errors left shelves empty.',
                'approach' => 'We built a web and mobile application for requesting, approving and tracking transfers, connected to the existing inventory system.',
                'result' => 'Transfers now take one day instead of four, and stock errors fell by two thirds in the first quarter.',
            ],
            'app-support' => [
                'client' => self::CLIENTS['bank'],
                'challenge' => 'A loan-servicing application failed most weeks, and the team that built it had moved on.',
                'approach' => 'We took over support, fixed the most frequent failures first and put monitoring in place.',
                'result' => 'Unplanned outages dropped from weekly to twice in the following year.',
            ],
            'testing' => [
                'client' => self::CLIENTS['insurer'],
                'challenge' => 'Every release of the claims portal brought a wave of urgent fixes.',
                'approach' => 'We added a release-readiness review, automated the core regression checks and tested each release before sign-off.',
                'result' => 'Defects reported by users after release fell by 70 percent over six releases.',
            ],
            'devops' => [
                'client' => self::CLIENTS['health'],
                'challenge' => 'Releases were manual, took a full evening and often had to be rolled back.',
                'approach' => 'We built a CI/CD pipeline and moved the application to cloud environments defined in versioned files.',
                'result' => 'Releases now take twenty minutes during the working day, with no rollbacks in the last quarter.',
            ],
            'staffing' => [
                'client' => self::CLIENTS['logistics'],
                'challenge' => 'A platform rebuild stalled for lack of two senior Java developers and a test engineer.',
                'approach' => 'We briefed on the roles, screened candidates for the skills the work needed and presented a shortlist.',
                'result' => 'All three roles were filled within a month, and two moved to permanent positions.',
            ],
            default => throw new InvalidArgumentException("No sample case story for {$slug}"),
        };
    }

    /**
     * @template T
     *
     * @param  callable(): T  $content
     * @return T|null
     */
    private function whenEnabled(callable $content): mixed
    {
        return $this->enabled() ? $content() : null;
    }
}
