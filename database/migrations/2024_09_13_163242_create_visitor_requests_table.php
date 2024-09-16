<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('visitor_requests', function (Blueprint $table) {
            $table->id();
            $table->string('name')->after('id');
            $table->string('email')->after('name');
            $table->string('subject');
            $table->text('message');
            $table->enum(
                'status',
                ['active', 'progress', 'resolved']
            )->default('active')->after('message');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('visitor_requests');
    }
};
