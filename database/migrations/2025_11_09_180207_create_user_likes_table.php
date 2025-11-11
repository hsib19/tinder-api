<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_likes', function (Blueprint $table) {
            $table->id(); 

            $table->foreignId('liker_id')
                  ->constrained('users', 'id')
                  ->cascadeOnDelete()
                  ->comment('User who liked');

            $table->foreignId('liked_id')
                  ->constrained('users', 'id')
                  ->cascadeOnDelete()
                  ->comment('User who was liked');

            $table->boolean('is_liked')->comment('True if like is active');
            $table->timestamp('created_at')->useCurrent();

            $table->index('liker_id', 'idx_likes_liker');
            $table->index('liked_id', 'idx_likes_liked');
        });

        DB::statement('ALTER TABLE user_likes ADD CONSTRAINT chk_liker_liked CHECK (liker_id <> liked_id);');
    }

    public function down(): void
    {
        Schema::dropIfExists('user_likes');
    }
};
