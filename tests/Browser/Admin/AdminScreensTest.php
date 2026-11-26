<?php

namespace Tests\Browser\Admin;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTruncation;
use Laravel\Dusk\Browser;
use Orchid\Platform\Models\Role;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\DuskTestCase;

class AdminScreensTest extends DuskTestCase
{
    use DatabaseTruncation;

    private User $admin;

    private Role $role;

    protected function setUp(): void
    {
        parent::setUp();

        User::createAdmin('Admin', 'admin@example.com', 'secret-password');
        $this->admin = User::where('email', 'admin@example.com')->firstOrFail();
        $this->role = Role::create(['slug' => 'editor', 'name' => 'Editor', 'permissions' => []]);
    }

    /**
     * Path ({user}/{role} are filled from fixtures), page title, screen heading.
     *
     * @return array<string, array{string, string, string}>
     */
    public static function screens(): array
    {
        return [
            'dashboard' => ['/admin/main', 'Get Started', 'Get Started'],
            'profile' => ['/admin/profile', 'My account', 'My account'],
            'users' => ['/admin/users', 'User', 'User'],
            'create user' => ['/admin/users/create', 'Create User', 'Create User'],
            'edit user' => ['/admin/users/{user}/edit', 'Edit User', 'Edit User'],
            'roles' => ['/admin/roles', 'Manage roles', 'Manage roles'],
            'create role' => ['/admin/roles/create', 'Manage roles', 'Manage roles'],
            'edit role' => ['/admin/roles/{role}/edit', 'Manage roles', 'Manage roles'],
            'example screen' => ['/admin/example', 'Example screen', 'Example screen'],
            'basic form controls' => ['/admin/example-fields', 'Basic form controls', 'Basic form controls'],
            'advanced form controls' => ['/admin/example-advanced', 'Advanced form controls', 'Advanced form controls'],
            'text editors' => ['/admin/example-editors', 'Form Text Editors', 'Form Text Editors'],
            'layouts' => ['/admin/example-layouts', 'Overview layouts', 'Overview layouts'],
            'charts' => ['/admin/example-charts', 'Charts', 'Charts'],
            'cards' => ['/admin/example-cards', 'Cards', 'Cards'],
        ];
    }

    #[DataProvider('screens')]
    public function test_admin_screen_renders(string $path, string $title, string $heading): void
    {
        $path = str_replace(['{user}', '{role}'], [$this->admin->id, $this->role->id], $path);

        $this->browse(function (Browser $browser) use ($path, $title, $heading) {
            $browser->loginAs($this->admin)
                ->visit($path)
                ->assertPathIs($path)
                ->assertTitle("{$title} - WeIntegralWebsite")
                ->assertSeeIn('h1', $heading);
        });
    }

    public function test_admin_can_create_a_role(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->admin)
                ->visit('/admin/roles/create')
                ->type('role[name]', 'Content Manager')
                ->type('role[slug]', 'content-manager')
                ->press('Save')
                ->waitForText('Role was saved')
                ->visit('/admin/roles')
                ->assertSee('Content Manager');
        });

        $this->assertDatabaseHas('roles', ['slug' => 'content-manager', 'name' => 'Content Manager']);
    }

    public function test_admin_users_list_shows_existing_admin(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->admin)
                ->visit('/admin/users')
                ->assertSee('admin@example.com');
        });
    }
}
