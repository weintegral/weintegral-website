<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Inertia\Response;

class ManagementController extends Controller
{
    /**
     * Leadership. Each leader is {name, title, bio, photoUrl, linkedInUrl}. The list
     * is empty until the owner supplies real profiles: the previous Team page only
     * showed the template's sample people.
     */
    public function teamAction(): Response
    {
        return Inertia::render('leadership', [
            'leaders' => [],
        ]);
    }

    /**
     * Contact. The page reads the contact details and offices from the shared site props.
     */
    public function contactAction(): Response
    {
        return Inertia::render('contact', [
            'visitorRequestUrl' => route('createCustomerRequest', absolute: false),
        ]);
    }
}
