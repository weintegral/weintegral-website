<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseTruncation;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

/**
 * The "Talk to an Expert" form on the Inertia Contact page submits a Visitor Request.
 */
class ContactFormTest extends DuskTestCase
{
    use DatabaseTruncation;

    private const FORM = '#visitor-request-form';

    /** The submit button is enabled once React has hydrated the server-rendered form. */
    private const FORM_READY = '#visitor-request-form button[type=submit]:enabled';

    public function test_visitor_can_send_a_visitor_request(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/contact')
                ->waitFor(self::FORM_READY)
                ->within(self::FORM, fn (Browser $form) => $this->fillValidRequest($form)->press('Send Message'))
                ->waitForText('Your message has been sent. Thank you!')
                ->assertMissing(self::FORM)
                ->press('Send another message')
                ->waitFor(self::FORM_READY)
                ->assertInputValue('name', '');
        });

        $this->assertDatabaseHas('visitor_requests', [
            'name' => 'Jane Visitor',
            'email' => 'jane@example.com',
            'subject' => 'Project enquiry',
            'message' => 'We would like to discuss a new project.',
        ]);
    }

    public function test_empty_form_shows_inline_errors_and_is_not_sent(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/contact')
                ->waitFor(self::FORM_READY)
                ->within(self::FORM, fn (Browser $form) => $form->press('Send Message'))
                ->waitForText('Please enter your name.')
                ->assertSee('Please enter your email address.')
                ->assertSee('Please enter a subject.')
                ->assertSee('Please enter a message.')
                ->assertAttribute('#visitor-request-name', 'aria-invalid', 'true');
        });

        $this->assertDatabaseCount('visitor_requests', 0);
    }

    public function test_invalid_email_is_reported_when_leaving_the_field(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/contact')
                ->waitFor(self::FORM_READY)
                ->type('email', 'jane@')
                ->click('#visitor-request-subject')
                ->waitForText('Please enter a valid email address.')
                ->append('email', 'example.com')
                ->click('#visitor-request-subject')
                ->waitUntilMissingText('Please enter a valid email address.');
        });
    }

    public function test_message_over_the_api_limit_is_rejected_before_sending(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/contact')
                ->waitFor(self::FORM_READY)
                ->within(self::FORM, fn (Browser $form) => $this->fillValidRequest($form)
                    ->type('message', str_repeat('a', 1001))
                    ->press('Send Message'))
                ->waitForText('The message must be 1000 characters or fewer.')
                ->assertDontSee('Your message has been sent. Thank you!');
        });

        $this->assertDatabaseCount('visitor_requests', 0);
    }

    public function test_server_validation_errors_are_shown_beside_their_fields(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/contact')
                ->waitFor(self::FORM_READY)
                // Answer as the API does when its rules reject a field the browser accepted.
                ->script($this->stubVisitorRequestResponse(422, [
                    'message' => 'The email must be a valid email address.',
                    'errors' => ['email' => ['The email must be a valid email address.']],
                ]));

            $this->fillValidRequest($browser)
                ->press('Send Message')
                ->waitForText('The email must be a valid email address.')
                ->assertAttribute('#visitor-request-email', 'aria-invalid', 'true')
                ->assertDontSee('Your message has been sent. Thank you!')
                ->assertDontSee('Your message could not be sent.');
        });
    }

    public function test_failed_submission_shows_an_error_and_keeps_the_message(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/contact')
                ->waitFor(self::FORM_READY)
                ->script($this->stubVisitorRequestResponse(500, ['message' => 'Error creating visitor request']));

            $this->fillValidRequest($browser)
                ->press('Send Message')
                ->waitForText('Your message could not be sent.')
                ->assertSee('info@weintegral.com')
                ->assertInputValue('message', 'We would like to discuss a new project.');
        });
    }

    private function fillValidRequest(Browser $browser): Browser
    {
        return $browser->type('name', 'Jane Visitor')
            ->type('email', 'jane@example.com')
            ->type('subject', 'Project enquiry')
            ->type('message', 'We would like to discuss a new project.');
    }

    /**
     * Replace fetch for the Visitor Request API with a canned response of the API's shape.
     *
     * @param  array<string, mixed>  $body
     */
    private function stubVisitorRequestResponse(int $status, array $body): string
    {
        $json = json_encode(json_encode($body));

        return <<<JS
            const realFetch = window.fetch;
            window.fetch = (url, options) => String(url).endsWith('/api/visitor-request')
                ? Promise.resolve(new Response({$json}, { status: {$status}, headers: { 'Content-Type': 'application/json' } }))
                : realFetch(url, options);
            JS;
    }
}
