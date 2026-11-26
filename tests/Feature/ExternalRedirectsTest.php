<?php

namespace Tests\Feature;

use Tests\TestCase;

/**
 * These routes leave the site, so they are asserted at the HTTP level rather than
 * in Dusk, where following them would make the browser suite depend on third-party hosts.
 */
class ExternalRedirectsTest extends TestCase
{
    public function test_blog_redirects_to_external_blog(): void
    {
        $this->get('/blog')->assertRedirect('https://blog.weintegral.com');
    }

    public function test_apps_redirects_to_link_page(): void
    {
        $this->get('/apps')->assertRedirect('https://lnk.bio/weintegral');
    }
}
