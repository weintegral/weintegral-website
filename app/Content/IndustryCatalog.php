<?php

namespace App\Content;

/**
 * The Industries WeIntegral serves: the one list behind the Industries page, the
 * homepage Industries strip and the footer (shared as `site.industries`).
 *
 * The names come from the previous Industries page, which was otherwise lorem
 * ipsum, and await owner confirmation (launch checklist). Each summary says what
 * WeIntegral offers the sector, without claiming specific past work.
 */
class IndustryCatalog
{
    /**
     * @return list<array{name: string, summary: string}>
     */
    public function all(): array
    {
        return [
            ['name' => 'Banking', 'summary' => 'Applications, testing and support for banks and credit unions, where security, accuracy and audit trails come first.'],
            ['name' => 'Insurance', 'summary' => 'Software and IT staff for insurers, from policy and claims systems to the integrations between them.'],
            ['name' => 'Ecommerce', 'summary' => 'Storefronts, integrations and the back-office systems behind them, tested to hold up when traffic peaks.'],
        ];
    }
}
