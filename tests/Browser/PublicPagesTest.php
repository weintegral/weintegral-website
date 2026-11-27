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
            'about' => ['/about', 'WEI - About', 'About Us'],
            'clients' => ['/clients', 'WEI - Clients', 'Clients'],
            'industries' => ['/industries', 'WEI - Industries', 'Industries'],
            'team' => ['/team', 'WEI - Team', 'Team'],
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

    public function test_home_page_renders_hero_and_contact_details(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                ->assertTitle('WEI - Home')
                ->assertPresent('#hero')
                ->assertSeeLink('info@weintegral.com')
                ->assertSee('+1 (512) 774-6577');
        });
    }

    /**
     * Header nav links that stay on this site (Blog leaves for blog.weintegral.com).
     *
     * @return array<string, array{string, string, string}>
     */
    public static function navigationLinks(): array
    {
        return [
            'about' => ['About', '/about', 'WEI - About'],
            'clients' => ['Clients', '/clients', 'WEI - Clients'],
        ];
    }

    #[DataProvider('navigationLinks')]
    public function test_header_navigation_link_opens_page_and_marks_it_active(string $link, string $path, string $title): void
    {
        $this->browse(function (Browser $browser) use ($link, $path, $title) {
            $browser->visit('/')
                ->within('#navbar', fn (Browser $nav) => $nav->clickLink($link))
                ->assertPathIs($path)
                ->assertTitle($title)
                ->assertSeeIn('#navbar a.active', $link);
        });
    }

    public function test_header_contact_link_opens_the_inertia_contact_page(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
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
            $browser->visit('/about')
                ->within('#header .logo', fn (Browser $logo) => $logo->clickLink('WeIntegral'))
                ->assertPathIs('/')
                ->assertTitle('WEI - Home');
        });
    }

    public function test_unknown_path_falls_back_to_home(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/this-page-does-not-exist')
                ->assertPathIs('/')
                ->assertTitle('WEI - Home');
        });
    }
}
