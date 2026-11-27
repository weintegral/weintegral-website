<?php

namespace App\Http\Controllers;

use App\Content\SampleContent;
use App\Services\ContactInfo;
use App\Services\Job;
use Inertia\Inertia;
use Inertia\Response;

class CareerController extends Controller
{
    /** Display names for the Job service's technology codes; other codes show as-is. */
    private const TECHNOLOGY_NAMES = [
        'NODEJS' => 'Node.js',
        'JAVASCRIPT' => 'JavaScript',
    ];

    public function __construct(
        private readonly Job $jobService,
        private readonly ContactInfo $contactInfo,
        private readonly SampleContent $sampleContent,
    ) {
    }

    public function indexAction(): Response
    {
        return Inertia::render('careers/index', [
            'seo' => self::seo(
                'Careers',
                'Build your IT career with WeIntegral. Browse open positions in development, testing and DevOps, and learn about our culture, benefits and candidate resources.',
            ),
            'openPositionCount' => count($this->jobService->getLatestRequirements()),
            'careersEmail' => $this->contactInfo->getHrEmailId(),
            'sample' => $this->sampleContent->careers(),
        ]);
    }

    public function cultureAction(): Response
    {
        return Inertia::render('careers/culture', [
            'seo' => self::seo(
                'Culture',
                'Life at WeIntegral: continuous learning, room to experiment and an inclusive, transparent workplace where every employee and consultant has a voice.',
            ),
        ]);
    }

    public function benefitsAction(): Response
    {
        return Inertia::render('careers/benefits', [
            'seo' => self::seo(
                'Benefits',
                'Benefits for WeIntegral employees and consultants, covering health, time off, retirement and career growth, plus how eligibility works for each role.',
            ),
            // Sample benefit specifics; null (placeholders shown) unless sample content is on.
            'sample' => $this->sampleContent->careers(),
        ]);
    }

    public function jobOpeningsAction(): Response
    {
        return Inertia::render('careers/open-positions', [
            'seo' => self::seo(
                'Open Positions',
                'Search open IT positions at WeIntegral by role, technology or skill, then apply by sending your résumé to our team. New roles are added as they open.',
            ),
            'openPositions' => array_map(
                fn (array $job) => $this->openPosition($job),
                $this->jobService->getLatestRequirements(),
            ),
            'careersEmail' => $this->contactInfo->getHrEmailId(),
        ]);
    }

    /**
     * Shapes a job from the Job service as the page's OpenPosition prop: a display
     * name for the technology code and the description's list items as plain skills.
     *
     * @param  array{id: string, primaryTechnology: string, role: string, brief: string, jobDescription: string}  $job
     * @return array{id: string, role: string, technology: string, summary: string, skills: list<string>}
     */
    private function openPosition(array $job): array
    {
        preg_match_all('#<li>(.*?)</li>#s', $job['jobDescription'], $items);

        return [
            'id' => $job['id'],
            'role' => $job['role'],
            'technology' => self::TECHNOLOGY_NAMES[$job['primaryTechnology']] ?? $job['primaryTechnology'],
            'summary' => $job['brief'],
            'skills' => array_map(fn (string $item) => trim(strip_tags($item)), $items[1]),
        ];
    }
}
