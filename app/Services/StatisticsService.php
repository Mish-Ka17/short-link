<?php

namespace App\Services;

use App\Models\Click;
use App\Models\ShortLink;
use Illuminate\Http\Request;

class StatisticsService
{
    /**
     * Сохраняет информацию о переходе.
     */
    public function store(
        ShortLink $shortLink,
        Request $request
    ): void {

        Click::create([

            'short_link_id' => $shortLink->id,

            'ip_address' => $request->ip(),

            'user_agent' => $request->userAgent(),

            'referer' => $request->header('referer'),

            'country' => null,

            'city' => null,

            'clicked_at' => now(),

        ]);

    }
}
