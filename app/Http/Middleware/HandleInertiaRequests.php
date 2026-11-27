<?php

namespace App\Http\Middleware;

use App\Content\IndustryCatalog;
use App\Content\ServiceCatalog;
use App\Services\ContactInfo;
use Illuminate\Http\Request;
use Inertia\Middleware;

/**
 * Sets up Inertia page responses and the props every page shares.
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

    public function __construct(
        private readonly ContactInfo $contactInfo,
        private readonly ServiceCatalog $serviceCatalog,
        private readonly IndustryCatalog $industryCatalog,
    ) {
    }

    /**
     * Props every page receives for the shared site shell (header, footer, SEO head)
     * and the pages that reuse its data (Contact, Industries, the homepage).
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
                'offices' => $this->contactInfo->offices(),
                'services' => $this->serviceCatalog->listings(),
                'industries' => $this->industryCatalog->all(),
                'canonicalUrl' => $request->url(),
                // Default Open Graph / Twitter image (Unsplash stock, docs/image-credits.md).
                'shareImage' => [
                    'url' => url('/img/social/default-share.jpg'),
                    'width' => 1200,
                    'height' => 630,
                    'alt' => 'A team working on laptops around a shared table',
                ],
            ],
        ];
    }
}
