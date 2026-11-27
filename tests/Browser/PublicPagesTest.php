<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\DuskTestCase;

class PublicPagesTest extends DuskTestCase
{
    /**
     * Every page rendered through layout/main: path, <title>, breadcrumb heading.
     *
     * @return array<string, array{string, string, string}>
     */
    public static function sitePages(): array
    {
        return [
            'terms of service' => ['/terms-of-service', 'WEI - Terms', 'Terms of Service'],
            'privacy policy' => ['/privacy-policy', 'WEI - Privacy', 'Privacy Policy'],
            'marketing submissions' => ['/marketing-data', 'WEI - Submissions', 'Marketing Data'],
            'marketing data' => ['/data', 'WEI - Submissions', 'Marketing Data'],
            'management resources' => ['/mgmt-resources', 'WEI - Resources', 'Resources'],
            'vendors' => ['/vendors', 'WEI - Resources', 'Vendors'],
            'job portals' => ['/job-portals', 'WEI - Resources', 'Job Portals'],
            'client list' => ['/client-list', 'WEI - Resources', 'Clients'],
            'job groups' => ['/job-groups', 'WEI - Job Groups', 'Job Groups'],
        ];
    }

    #[DataProvider('sitePages')]
    public function test_site_page_renders_with_layout(string $path, string $title, string $heading): void
    {
        $this->browse(function (Browser $browser) use ($path, $title, $heading) {
            $browser->visit($path)
                ->assertPathIs($path)
                ->assertTitle($title)
                ->assertSeeIn('.breadcrumbs h2', $heading)
                ->assertPresent('#header')
                ->assertPresent('footer');
        });
    }

    public function test_header_about_link_opens_the_inertia_who_we_are_page(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/privacy-policy')
                ->within('#navbar', fn (Browser $nav) => $nav->clickLink('About'))
                ->assertPathIs('/about')
                ->waitForTextIn('h1', 'Who We Are')
                ->assertTitle('Who We Are | WeIntegral');
        });
    }

    public function test_header_contact_link_opens_the_inertia_contact_page(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/privacy-policy')
                ->within('#navbar', fn (Browser $nav) => $nav->clickLink('Contact'))
                ->assertPathIs('/contact')
                ->waitForTextIn('h1', 'Contact')
                ->assertTitle('Contact | WeIntegral')
                ->assertSeeLink('info@weintegral.com')
                ->assertSee('+1 (512) 774-6577')
                ->assertPresent('#visitor-request-form');
        });
    }

    public function test_logo_links_back_to_home(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/privacy-policy')
                ->within('#header .logo', fn (Browser $logo) => $logo->clickLink('WeIntegral'))
                ->assertPathIs('/')
                ->waitForTextIn('h1', 'One team for the software your business runs on.')
                ->assertTitle('IT Services and IT Staffing | WeIntegral');
        });
    }

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
