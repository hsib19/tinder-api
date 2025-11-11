<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_pictures', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')
                  ->constrained('users', 'id')
                  ->cascadeOnDelete()
                  ->comment('Owner of the picture');

            $table->string('url', 255)->comment('Image URL or path');
            $table->boolean('is_primary')->default(false)->comment('True if this is the user\'s main picture');
            $table->timestamp('created_at')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_pictures');
    }
};
