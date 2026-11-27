<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class PublicPagesTest extends DuskTestCase
{
    // Every public page now renders through Inertia; per-page and navigation
    // coverage lives in the page-specific tests and SiteShellTest.

    public function test_unknown_path_falls_back_to_home(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/this-page-does-not-exist')
                ->assertPathIs('/')
                ->waitForTextIn('h1', 'One team for the software your business runs on.')
                ->assertTitle('IT Services and IT Staffing | WeIntegral');
        });
    }
}
