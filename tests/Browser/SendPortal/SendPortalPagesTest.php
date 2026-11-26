<?php

namespace Tests\Browser\SendPortal;

use Illuminate\Foundation\Testing\DatabaseTruncation;
use Illuminate\Support\Facades\DB;
use Laravel\Dusk\Browser;
use PHPUnit\Framework\Attributes\DataProvider;
use Sendportal\Base\Models\Campaign;
use Sendportal\Base\Models\EmailService;
use Sendportal\Base\Models\Message;
use Sendportal\Base\Models\Subscriber;
use Sendportal\Base\Models\Tag;
use Sendportal\Base\Models\Template;
use Tests\DuskTestCase;

class SendPortalPagesTest extends DuskTestCase
{
    use DatabaseTruncation;

    /** @var array<string, int|string> */
    private array $ids;

    protected function setUp(): void
    {
        parent::setUp();

        $service = EmailService::factory()->create(['name' => 'Primary SES']);
        $template = Template::factory()->create(['name' => 'Newsletter Layout']);
        $tag = Tag::factory()->create(['name' => 'Prospects']);
        $subscriber = Subscriber::factory()->create([
            'email' => 'subscriber@example.com',
            'first_name' => 'Sam',
            'last_name' => 'Reader',
        ]);
        $campaign = Campaign::factory()->create([
            'name' => 'October Newsletter',
            'email_service_id' => $service->id,
            'template_id' => $template->id,
            'content' => '<p>Campaign body</p>',
        ]);
        $message = Message::factory()->create([
            'subscriber_id' => $subscriber->id,
            'source_id' => $campaign->id,
        ]);

        $this->ids = [
            '{service}' => $service->id,
            '{tag}' => $tag->id,
            '{template}' => $template->id,
            '{subscriber}' => $subscriber->id,
            '{campaign}' => $campaign->id,
            '{message}' => $message->id,
            '{hash}' => $message->hash,
        ];
    }

    /**
     * Path (placeholders filled from fixtures), title prefix, text expected on the page.
     *
     * @return array<string, array{string, string, string}>
     */
    public static function pages(): array
    {
        return [
            'campaigns' => ['/sendportal/campaigns', 'Campaigns', 'October Newsletter'],
            'create campaign' => ['/sendportal/campaigns/create', 'Create Campaign', 'Campaign Name'],
            'sent campaigns' => ['/sendportal/campaigns/sent', 'Campaigns', 'Sent'],
            'edit campaign' => ['/sendportal/campaigns/{campaign}/edit', 'Edit Campaign', 'Edit Campaign'],
            'preview campaign' => ['/sendportal/campaigns/{campaign}/preview', 'Confirm Campaign', 'Preview Campaign: October Newsletter'],
            'confirm campaign delete' => ['/sendportal/campaigns/{campaign}/confirm-delete', 'Delete Campaign', 'Delete Campaign - October Newsletter'],
            'messages' => ['/sendportal/messages', 'Messages', 'Messages'],
            'draft messages' => ['/sendportal/messages/draft', 'Messages', 'Draft'],
            'message' => ['/sendportal/messages/{message}/show', 'Message', 'Draft Message'],
            'email services' => ['/sendportal/email-services', 'Email Services', 'Primary SES'],
            'create email service' => ['/sendportal/email-services/create', 'WeIntegralWebsite', 'Add Email Service'],
            'edit email service' => ['/sendportal/email-services/{service}/edit', 'WeIntegralWebsite', 'Edit Email Service'],
            'test email service' => ['/sendportal/email-services/{service}/test', 'WeIntegralWebsite', 'Test Email Service'],
            'tags' => ['/sendportal/tags', 'Tags', 'Prospects'],
            'create tag' => ['/sendportal/tags/create', 'New Tag', 'Create Tag'],
            'edit tag' => ['/sendportal/tags/{tag}/edit', 'Edit Tag', 'Edit Tag'],
            'templates' => ['/sendportal/templates', 'Email Templates', 'Newsletter Layout'],
            'create template' => ['/sendportal/templates/create', 'New Template', 'Create Template'],
            'edit template' => ['/sendportal/templates/{template}/edit', 'Templates', 'Edit Template'],
            'subscribers' => ['/sendportal/subscribers', 'Subscribers', 'subscriber@example.com'],
            'create subscriber' => ['/sendportal/subscribers/create', 'New Subscriber', 'Create Subscriber'],
            'import subscribers' => ['/sendportal/subscribers/import', 'WeIntegralWebsite', 'Import Subscribers'],
            'subscriber' => ['/sendportal/subscribers/{subscriber}', 'Subscriber : Sam Reader', 'subscriber@example.com'],
            'edit subscriber' => ['/sendportal/subscribers/{subscriber}/edit', 'Edit Subscriber : Sam Reader', 'Edit Subscriber'],
        ];
    }

    #[DataProvider('pages')]
    public function test_sendportal_page_renders(string $path, string $title, string $text): void
    {
        $path = strtr($path, $this->ids);

        $this->browse(function (Browser $browser) use ($path, $title, $text) {
            $browser->visit($path)
                ->assertPathIs($path)
                ->assertTitleContains($title)
                ->assertSee($text);
        });
    }

    public function test_dashboard_renders(): void
    {
        // The dashboard's subscriber-growth query calls MySQL's date_format(), which sqlite lacks.
        if (DB::connection()->getDriverName() === 'sqlite') {
            $this->markTestSkipped('SendPortal dashboard needs MySQL; set DB_CONNECTION=mysql in .env.dusk.development.');
        }

        $this->browse(function (Browser $browser) {
            $browser->visit('/sendportal')
                ->assertPathIs('/sendportal')
                ->assertTitleContains('Dashboard');
        });
    }

    public function test_tag_can_be_created(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/sendportal/tags/create')
                ->type('name', 'Customers')
                ->press('Save')
                ->waitForLocation('/sendportal/tags')
                ->assertSee('Customers');
        });

        $this->assertDatabaseHas('sendportal_tags', ['name' => 'Customers']);
    }

    public function test_subscriber_can_be_created(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/sendportal/subscribers/create')
                ->type('email', 'new.person@example.com')
                ->type('first_name', 'New')
                ->type('last_name', 'Person')
                ->press('Save')
                ->waitForLocation('/sendportal/subscribers')
                ->assertSee('new.person@example.com');
        });

        $this->assertDatabaseHas('sendportal_subscribers', [
            'email' => 'new.person@example.com',
            'first_name' => 'New',
            'last_name' => 'Person',
        ]);
    }

    public function test_message_webview_shows_campaign_content(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit("/webview/{$this->ids['{hash}']}")
                ->assertSee('Campaign body');
        });
    }

    public function test_subscriber_can_unsubscribe_from_email_link(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit("/subscriptions/unsubscribe/{$this->ids['{hash}']}")
                ->assertSee('Remove subscriber@example.com from this email list?')
                ->press('Unsubscribe now')
                ->waitUntilMissingText('Unsubscribe now');
        });

        $this->assertNotNull(Subscriber::find($this->ids['{subscriber}'])->unsubscribed_at);
    }
}
