<?php

namespace App\Http\Controllers;

use App\Content\SampleContent;
use Inertia\Inertia;
use Inertia\Response;

class ManagementController extends Controller
{
    public function __construct(private readonly SampleContent $sampleContent)
    {
    }

    /**
     * Leadership. Each leader is {name, title, bio, initials, photoUrl, linkedInUrl}.
     * The list is empty until the owner supplies real profiles (the previous Team page
     * only showed the template's sample people), or fictional when sample content is on.
     */
    public function teamAction(): Response
    {
        return Inertia::render('leadership', [
            'seo' => self::seo(
                'Leadership',
                'Meet the leadership team behind WeIntegral, the IT services firm for application development, support, testing, DevOps and IT staffing.',
            ),
            'leaders' => $this->sampleContent->leaders() ?? [],
        ]);
    }

    /**
     * Contact. The page reads the contact details and offices from the shared site props.
     */
    public function contactAction(): Response
    {
        return Inertia::render('contact', [
            'seo' => self::seo(
                'Contact',
                'Talk to an Expert at WeIntegral about application development, support, testing, DevOps or IT staffing. Send us a message or call our Lakeway, TX office.',
            ),
            'visitorRequestUrl' => route('createCustomerRequest', absolute: false),
        ]);
    }
}
