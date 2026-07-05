<?php

namespace App\Http\Controllers;

use App\Models\ShortLink;
use Illuminate\Http\RedirectResponse;
use App\Services\StatisticsService;
use Illuminate\Http\Request;

class RedirectController extends Controller
{
    public function __construct(
        private StatisticsService $statistics
    ) { }

    // Переход по короткой ссылке.

    public function __invoke(Request $request, string $code): RedirectResponse
    {
        $shortLink = ShortLink::where('short_code', $code)
            ->where('is_active', true)
            ->firstOrFail();

        // Проверяем срок действия ссылки
        if (
            $shortLink->expires_at !== null &&
            $shortLink->expires_at->isPast()
        ) {
            abort(410);
        }

        // Сохраняем статистику
        $this->statistics->store(
            $shortLink,
            $request
        );

        return redirect()->away($shortLink->original_url);
    }
}
