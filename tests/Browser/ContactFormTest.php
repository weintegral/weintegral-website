<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseTruncation;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class ContactFormTest extends DuskTestCase
{
    use DatabaseTruncation;

    public function test_visitor_can_send_a_message(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/contact')
                ->within('form.php-email-form', function (Browser $form) {
                    $form->type('name', 'Jane Visitor')
                        ->type('email', 'jane@example.com')
                        ->type('subject', 'Project enquiry')
                        ->type('message', 'We would like to discuss a new project.')
                        ->press('Send Message')
                        ->waitForText('Your message has been sent. Thank you!')
                        // validate.js resets the form after a successful submit.
                        ->assertInputValue('name', '');
                });
        });

        $this->assertDatabaseHas('visitor_requests', [
            'name' => 'Jane Visitor',
            'email' => 'jane@example.com',
            'subject' => 'Project enquiry',
            'message' => 'We would like to discuss a new project.',
        ]);
    }

    public function test_message_rejected_by_server_validation_shows_an_error(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/contact')
                ->within('form.php-email-form', function (Browser $form) {
                    // Browser-side `required` passes; the 1000-char server limit does not.
                    $form->type('name', 'Jane Visitor')
                        ->type('email', 'jane@example.com')
                        ->type('subject', 'Too long')
                        ->type('message', str_repeat('a', 1001))
                        ->press('Send Message')
                        ->waitFor('.error-message.d-block')
                        ->assertDontSee('Your message has been sent. Thank you!');
                });
        });

        $this->assertDatabaseCount('visitor_requests', 0);
    }

    public function test_browser_blocks_submission_with_empty_required_fields(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/contact')
                ->within('form.php-email-form', fn (Browser $form) => $form->press('Send Message'))
                ->pause(500)
                ->assertScript("document.querySelector('form.php-email-form').checkValidity()", false)
                ->assertDontSee('Your message has been sent. Thank you!');
        });

        $this->assertDatabaseCount('visitor_requests', 0);
    }
}
