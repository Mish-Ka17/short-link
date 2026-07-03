<?php

namespace App\Services;

use App\Models\ShortLink;
use Illuminate\Support\Str;

class ShortCodeGenerator
{
    /**
     * Длина короткого кода.
     */
    private const DEFAULT_LENGTH = 6;

    /**
     * Генерирует уникальный короткий код.
     */
    public function generate(int $length = self::DEFAULT_LENGTH): string
    {
        do {
            $code = Str::random($length);
        } while ($this->exists($code));

        return $code;
    }

    /**
     * Проверяет существование кода в базе.
     */
    protected function exists(string $code): bool
    {
        return ShortLink::where('short_code', $code)->exists();
    }
}
