<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('public_holidays', function (Blueprint $table) {
            $table->text('display_message')->nullable()->after('description');
            $table->date('notification_start_date')->nullable()->after('display_message');
            $table->date('notification_end_date')->nullable()->after('notification_start_date');
            $table->boolean('show_on_dashboard')->default(true)->after('notification_end_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('public_holidays', function (Blueprint $table) {
            $table->dropColumn(['display_message', 'notification_start_date', 'notification_end_date', 'show_on_dashboard']);
        });
    }
};
