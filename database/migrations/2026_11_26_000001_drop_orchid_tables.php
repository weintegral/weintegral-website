<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Orchid was removed from the app. Its roles, role-users and attachments tables
 * and the `permissions` column it added to `users` are dropped with their data.
 * Safe on any database: each table and the column are dropped only if they
 * exist. This cannot be reversed; down() restores nothing.
 */
return new class extends Migration
{
    /**
     * Every table Orchid's migrations created, children before parents.
     *
     * @var array<int, string>
     */
    private array $tables = [
        'role_users',
        'roles',
        'attachmentable',
        'attachments',
    ];

    public function up(): void
    {
        Schema::withoutForeignKeyConstraints(function () {
            foreach ($this->tables as $table) {
                Schema::dropIfExists($table);
            }
        });

        if (Schema::hasColumn('users', 'permissions')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('permissions');
            });
        }
    }

    public function down(): void
    {
        // Intentionally irreversible: Orchid and its data are gone.
    }
};
