<?php

namespace Tests\Feature;

use Inertia\Testing\AssertableInertia;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

/**
 * Terms of Service and Privacy Policy are public Inertia pages at their
 * existing URLs, indexable and listed in the sitemap.
 */
class LegalPagesTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->withoutVite();
    }

    /**
     * @return array<string, array{string, string}>
     */
    public static function legalPages(): array
    {
        return [
            'terms of service' => ['/terms-of-service', 'legal/terms-of-service'],
            'privacy policy' => ['/privacy-policy', 'legal/privacy-policy'],
        ];
    }

    /**
     * @return array<string, array{string}>
     */
    public static function legalPagePaths(): array
    {
        return array_map(fn (array $case) => [$case[0]], self::legalPages());
    }

    #[DataProvider('legalPages')]
    public function test_legal_page_renders_its_inertia_component(string $path, string $component): void
    {
        $this->get($path)
            ->assertOk()
            ->assertInertia(fn (AssertableInertia $page) => $page
                ->component($component)
                ->where('contactEmail', 'info@weintegral.com')
            );
    }

    #[DataProvider('legalPagePaths')]
    public function test_legal_page_stays_indexable(string $path): void
    {
        $response = $this->get($path);

        $response->assertHeaderMissing('X-Robots-Tag');
        $response->assertDontSee('name="robots"', escape: false);
    }
}
