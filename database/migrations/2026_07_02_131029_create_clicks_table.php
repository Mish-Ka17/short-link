<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('clicks', function (Blueprint $table) {

            $table->id();

            $table->foreignId('short_link_id')
                ->constrained()
                ->cascadeOnDelete();

            // IP посетителя
            $table->ipAddress('ip_address');

            // браузер
            $table->text('user_agent')
                ->nullable();

            // откуда пришёл
            $table->text('referer')
                ->nullable();

            // страна
            $table->string('country')
                ->nullable();

            // город
            $table->string('city')
                ->nullable();

            // время перехода
            $table->timestamp('clicked_at');

            $table->timestamps();

            // Индексы

            $table->index('short_link_id');

            $table->index('clicked_at');

            $table->index('ip_address');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('clicks');
    }
};
