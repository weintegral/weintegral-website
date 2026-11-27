<?php

namespace Tests\Feature;

use Tests\TestCase;

/**
 * SendPortal was removed; its former URLs must not serve anything.
 */
class RemovedSendPortalTest extends TestCase
{
    public function test_sendportal_returns_not_found(): void
    {
        $this->get('/sendportal')->assertNotFound();
    }

    public function test_sendportal_sub_path_returns_not_found(): void
    {
        $this->get('/sendportal/campaigns')->assertNotFound();
    }

    public function test_resources_pages_do_not_link_to_sendportal(): void
    {
        // /resources is an Inertia page; the Vite manifest is a build artifact.
        $this->withoutVite();

        $this->get('/resources')->assertOk()->assertDontSee('/sendportal');
        $this->get('/mgmt-resources')->assertOk()->assertDontSee('/sendportal');
    }

    public function test_published_sendportal_assets_are_gone(): void
    {
        $this->assertDirectoryDoesNotExist(public_path('vendor/sendportal'));
    }
}
