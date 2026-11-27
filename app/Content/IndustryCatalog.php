<?php

namespace App\Content;

/**
 * The Industries WeIntegral serves: the one list behind the Industries page, the
 * homepage Industries strip and the footer (shared as `site.industries`).
 *
 * The names come from the previous Industries page, which was otherwise lorem
 * ipsum: each awaits owner confirmation and a one-line summary (null until
 * supplied), both tracked in the launch checklist.
 */
class IndustryCatalog
{
    /**
     * @return list<array{name: string, summary: string|null}>
     */
    public function all(): array
    {
        return [
            ['name' => 'Banking', 'summary' => null],
            ['name' => 'Insurance', 'summary' => null],
            ['name' => 'Ecommerce', 'summary' => null],
        ];
    }
}
