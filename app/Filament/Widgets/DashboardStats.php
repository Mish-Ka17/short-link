<?php

namespace App\Filament\Widgets;

use App\Models\Click;
use App\Models\ShortLink;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class DashboardStats extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        return [

            Stat::make(
                'Пользователей',
                User::count(),
            )
                ->description('Всего зарегистрировано')
                ->color('primary')
                ->icon('heroicon-o-users'),

            Stat::make(
                'Коротких ссылок',
                ShortLink::count(),
            )
                ->description('Всего создано')
                ->color('success')
                ->icon('heroicon-o-link'),

            Stat::make(
                'Всего переходов',
                Click::count(),
            )
                ->description('За всё время')
                ->color('warning')
                ->icon('heroicon-o-cursor-arrow-rays'),

            Stat::make(
                'За сегодня',
                Click::whereDate('created_at', today())->count(),
            )
                ->description('Переходов сегодня')
                ->color('danger')
                ->icon('heroicon-o-calendar-days'),

        ];
    }
}
