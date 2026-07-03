<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('short_links', function (Blueprint $table) {

            $table->id();

            // владелец ссылки
            $table->foreignId('user_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();

            // исходный URL
            $table->text('original_url');

            // короткий код
            $table->string('short_code', 20)
                ->unique();

            // название ссылки
            $table->string('title')
                ->nullable();

            // активна ли ссылка
            $table->boolean('is_active')
                ->default(true);

            // дата окончания действия
            $table->timestamp('expires_at')
                ->nullable();

            $table->timestamps();

            // Индексы

            $table->index('user_id');

            $table->index('short_code');

            $table->index('is_active');

            $table->index('expires_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('short_links');
    }
};
