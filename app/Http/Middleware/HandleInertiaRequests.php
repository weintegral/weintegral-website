<?php

namespace App\Http\Middleware;

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
}
