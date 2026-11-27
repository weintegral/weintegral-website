<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * A public page's `seo` prop: its title (without the site name) and a unique meta
     * description of roughly 120 to 160 characters. The page's Seo component renders
     * them, and app.blade.php renders them server-side when SSR is unavailable.
     *
     * @return array{title: string, description: string}
     */
    protected static function seo(string $title, string $description): array
    {
        return ['title' => $title, 'description' => $description];
    }
}
