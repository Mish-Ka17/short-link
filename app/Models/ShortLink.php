<?php

namespace App\Models;

use App\Services\ShortCodeGenerator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Casts\Attribute;

class ShortLink extends Model
{
    use HasFactory;

    /**
     * Поля, разрешенные для массового заполнения.
     */
    protected $fillable = [
        'user_id',
        'original_url',
        'short_code',
        'title',
        'is_active',
        'expires_at',
    ];

    /**
     * Приведение типов.
     */
    protected $casts = [
        'is_active' => 'boolean',
        'expires_at' => 'datetime',
    ];

    /**
     * Пользователь — владелец ссылки.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Все переходы по ссылке.
     */
    public function clicks(): HasMany
    {
        return $this->hasMany(Click::class);
    }

    /**
     * Автоматическая генерация короткого кода (короткой ссылки).
     */
    protected static function booted(): void
    {
        static::creating(function (ShortLink $link) {

            if (auth()->check()) {

            $link->user_id = auth()->id();

            }

            if (empty($link->short_code)) {

                $link->short_code = app(ShortCodeGenerator::class)
                    ->generate();
            }

        });
    }
   /**
     * Вычисляемый атрибут для полной короткой ссылки
     */
    protected function shortUrl(): Attribute
    {
        return Attribute::make(
            get: fn () => url($this->short_code),
        );
    }
}
