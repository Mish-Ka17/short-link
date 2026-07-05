<?php

namespace App\Services;

use App\Models\ShortLink;
use Illuminate\Support\Str;

class ShortCodeGenerator
{

    private const DEFAULT_LENGTH = 6;


    // Генерация уникального короткого кода

    public function generate(int $length = self::DEFAULT_LENGTH): string
    {
        do {
            $code = Str::random($length);
        } while ($this->exists($code));

        return $code;
    }

    // Проверка существования кода в БД

    protected function exists(string $code): bool
    {
        return ShortLink::where('short_code', $code)->exists();
    }
}
