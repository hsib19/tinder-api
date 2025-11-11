<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('admin_notifications', function (Blueprint $table) {
            $table->id(); 

            $table->foreignId('user_id')
                  ->constrained('users', 'id')
                  ->cascadeOnDelete()
                  ->comment('User who triggered the notification');

            $table->string('email_sent_to', 150)->comment('Admin email that received the notification');

            $table->string('status', 20)->default('pending')->comment('Notification status: pending or sent');

            $table->timestamp('created_at')->useCurrent();
        });

        DB::statement("ALTER TABLE admin_notifications ADD CONSTRAINT chk_notification_status CHECK (status IN ('pending', 'sent'));");
    }

    public function down(): void
    {
        Schema::dropIfExists('admin_notifications');
    }
};
