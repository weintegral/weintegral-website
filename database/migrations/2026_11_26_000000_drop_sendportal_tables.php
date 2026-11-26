<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

/**
 * SendPortal was removed from the app. Its tables (created by the package's own
 * migrations) are dropped with their data. Safe on any database: each table is
 * dropped only if it exists. This cannot be reversed; down() restores nothing.
 */
return new class extends Migration
{
    /**
     * Every table SendPortal's migrations leave behind, plus the intermediate
     * prefixed names it used before renaming segments to tags.
     *
     * @var array<int, string>
     */
    private array $tables = [
        'sendportal_campaign_tag',
        'sendportal_campaign_segment',
        'sendportal_tag_subscriber',
        'sendportal_segment_subscriber',
        'sendportal_message_failures',
        'sendportal_message_urls',
        'sendportal_messages',
        'sendportal_campaigns',
        'sendportal_campaign_statuses',
        'sendportal_templates',
        'sendportal_tags',
        'sendportal_segments',
        'sendportal_subscribers',
        'sendportal_unsubscribe_event_types',
        'sendportal_email_services',
        'sendportal_email_service_types',
    ];

    public function up(): void
    {
        Schema::withoutForeignKeyConstraints(function () {
            foreach ($this->tables as $table) {
                Schema::dropIfExists($table);
            }
        });
    }

    public function down(): void
    {
        // Intentionally irreversible: SendPortal and its data are gone.
    }
};
