<?php

namespace Tests\Browser\Admin;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTruncation;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class AdminAuthenticationTest extends DuskTestCase
{
    use DatabaseTruncation;

    protected function setUp(): void
    {
        parent::setUp();

        User::createAdmin('Admin', 'admin@example.com', 'correct-password');
    }

    /**
     * Orchid's "Remember Me" (checked by default) leaves a lock cookie that turns the
     * login page into a lock screen, so every test starts from a cookie-free browser.
     */
    private function freshLoginPage(Browser $browser): Browser
    {
        $browser->visit('/admin/login')->driver->manage()->deleteAllCookies();

        return $browser->refresh();
    }

    public function test_guest_is_sent_to_login_page(): void
    {
        $this->browse(function (Browser $browser) {
            $this->freshLoginPage($browser)
                ->visit('/admin/main')
                ->assertPathIs('/admin/login')
                ->assertSee('Sign in to your account');
        });
    }

    public function test_admin_can_log_in_and_out(): void
    {
        $this->browse(function (Browser $browser) {
            $this->freshLoginPage($browser)
                ->type('email', 'admin@example.com')
                ->type('password', 'correct-password')
                ->press('Login')
                ->waitForLocation('/admin/main')
                ->assertSee('Get Started')
                ->assertAuthenticatedAs(User::where('email', 'admin@example.com')->first())
                ->logout()
                ->visit('/admin/main')
                ->assertPathIs('/admin/login');
        });
    }

    public function test_wrong_password_is_rejected(): void
    {
        $this->browse(function (Browser $browser) {
            $this->freshLoginPage($browser)
                ->type('email', 'admin@example.com')
                ->type('password', 'wrong-password')
                ->press('Login')
                ->waitForText('The details you entered did not match our records.')
                ->assertPathIs('/admin/login')
                ->assertGuest();
        });
    }
}
