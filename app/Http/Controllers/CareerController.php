<?php

namespace App\Http\Controllers;

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
    ) {
    }

    public function indexAction(): Response
    {
        return Inertia::render('careers/index', [
            'openPositionCount' => count($this->jobService->getLatestRequirements()),
            'careersEmail' => $this->contactInfo->getHrEmailId(),
        ]);
    }

    public function cultureAction(): Response
    {
        return Inertia::render('careers/culture');
    }

    public function benefitsAction(): Response
    {
        return Inertia::render('careers/benefits');
    }

    public function jobOpeningsAction(): Response
    {
        return Inertia::render('careers/open-positions', [
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
