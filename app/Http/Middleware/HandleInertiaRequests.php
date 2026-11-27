<?php

namespace App\Http\Middleware;

use App\Services\ContactInfo;
use Illuminate\Http\Request;
use Inertia\Middleware;

/**
 * Serves Inertia page responses. Blade responses pass through untouched.
 */
class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that's loaded on the first page visit.
     *
     * @see https://inertiajs.com/server-side-setup#root-template
     *
     * @var string
     */
    protected $rootView = 'app';

    public function __construct(private readonly ContactInfo $contactInfo)
    {
    }

    /**
     * Props every page receives for the shared site shell (header, footer, SEO head).
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        return [
            ...parent::share($request),
            'site' => [
                'contact' => [
                    'email' => $this->contactInfo->getAdminEmailId(),
                    'phone' => $this->contactInfo->getPhoneNumber(),
                ],
                'offices' => [
                    ['name' => 'Corporate office', 'addressLines' => $this->contactInfo->addressLines($this->contactInfo->getCorporateAddress())],
                    ['name' => 'Overseas office', 'addressLines' => $this->contactInfo->addressLines($this->contactInfo->getOverseasAddress())],
                ],
                'canonicalUrl' => $request->url(),
            ],
        ];
    }
}
