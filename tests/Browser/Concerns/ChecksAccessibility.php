<?php

namespace Tests\Browser\Concerns;

use Laravel\Dusk\Browser;

/**
 * Runs axe-core (from node_modules) in the page under test and fails on any
 * WCAG 2.2 A/AA or best-practice violation.
 */
trait ChecksAccessibility
{
    private const AXE_TAGS = ['wcag2a', 'wcag2aa', 'wcag21a', 'wcag21aa', 'wcag22aa', 'best-practice'];

    protected function assertNoAxeViolations(Browser $browser): void
    {
        $browser->driver->manage()->timeouts()->setScriptTimeout(30);
        $browser->driver->executeScript(file_get_contents(base_path('node_modules/axe-core/axe.min.js')));

        $json = $browser->driver->executeAsyncScript(<<<'JS'
            const done = arguments[arguments.length - 1];
            axe.run(document, { runOnly: { type: 'tag', values: arguments[0] } })
                .then((results) => done(JSON.stringify(results.violations.map((violation) => ({
                    id: violation.id,
                    impact: violation.impact,
                    help: violation.help,
                    nodes: violation.nodes.map((node) => node.target.join(' ') + ' :: ' + node.failureSummary),
                })))))
                .catch((error) => done(JSON.stringify([{ id: 'axe-error', help: String(error) }])));
            JS, [self::AXE_TAGS]);

        $violations = json_decode($json, true);

        $this->assertSame([], $violations, 'axe found accessibility violations: '.json_encode($violations, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
    }

    /**
     * Sets prefers-color-scheme ('light' or 'dark') via Chrome DevTools media emulation.
     * It persists across navigations in this browser session.
     */
    protected function emulateColorScheme(Browser $browser, string $scheme): void
    {
        $browser->driver->executeCustomCommand(
            '/session/:sessionId/goog/cdp/execute',
            'POST',
            ['cmd' => 'Emulation.setEmulatedMedia', 'params' => ['features' => [['name' => 'prefers-color-scheme', 'value' => $scheme]]]],
        );
    }
}
