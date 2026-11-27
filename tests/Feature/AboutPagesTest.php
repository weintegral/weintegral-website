<?php

namespace Tests\Feature;

use Inertia\Testing\AssertableInertia;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

/**
 * The About section (Who We Are, Leadership) and the Industries page are
 * Inertia pages. Laravel owns their facts and hands them over as props.
 */
class AboutPagesTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        // The Vite manifest is a build artifact; these tests only inspect the page object.
        $this->withoutVite();
    }

    public function test_who_we_are_page_renders_the_about_component_with_statistics_awaiting_confirmation(): void
    {
        $this->get('/about')
            ->assertOk()
            ->assertInertia(fn (AssertableInertia $page) => $page
                ->component('about')
                ->where('stats', [
                    ['value' => '110', 'label' => 'Clients served'],
                    ['value' => '150', 'label' => 'Projects delivered'],
                    ['value' => '1,463', 'label' => 'Hours of support'],
                    ['value' => '25', 'label' => 'Employees'],
                ])
            );
    }

    /**
     * The previous Team page only showed the template's sample people (Walter White,
     * Sarah Jhinson, William Anderson) with lorem-ipsum bios, so no leader is
     * published until the owner supplies real profiles.
     */
    public function test_leadership_page_renders_the_leadership_component_without_sample_people(): void
    {
        $this->get('/team')
            ->assertOk()
            ->assertInertia(fn (AssertableInertia $page) => $page
                ->component('leadership')
                ->where('leaders', [])
            )
            ->assertDontSee('Walter White')
            ->assertDontSee('Sarah Jhinson')
            ->assertDontSee('William Anderson');
    }

    /**
     * The Industry names come from the previous (lorem-ipsum) Industries page and
     * await owner confirmation; their lorem-ipsum bullet points are not carried over.
     */
    public function test_industries_page_renders_the_industries_component_with_each_industry(): void
    {
        $this->get('/industries')
            ->assertOk()
            ->assertInertia(fn (AssertableInertia $page) => $page
                ->component('industries')
                ->where('industries', [
                    ['name' => 'Banking', 'summary' => null],
                    ['name' => 'Insurance', 'summary' => null],
                    ['name' => 'Ecommerce', 'summary' => null],
                ])
            )
            ->assertDontSee('adipiscing');
    }

    /**
     * The Clients page was dropped by owner decision; old links land on Who We Are.
     *
     * @return array<string, array{string}>
     */
    public static function droppedClientsPaths(): array
    {
        return [
            'clients' => ['/clients'],
            'clients with trailing slash' => ['/clients/'],
            'client detail' => ['/clients/acme'],
            'nested client detail' => ['/clients/acme/projects'],
        ];
    }

    #[DataProvider('droppedClientsPaths')]
    public function test_dropped_clients_page_permanently_redirects_to_who_we_are(string $path): void
    {
        $this->get($path)
            ->assertStatus(301)
            ->assertRedirect('/about');
    }
}
