<?php

namespace Tests\Feature;

use Tests\TestCase;

/**
 * Orchid's admin panel was removed; its former URLs must not serve anything.
 */
class RemovedOrchidTest extends TestCase
{
    public function test_admin_returns_not_found(): void
    {
        $this->get('/admin')->assertNotFound();
    }

    public function test_admin_sub_path_returns_not_found(): void
    {
        $this->get('/admin/systems/users')->assertNotFound();
    }
}
