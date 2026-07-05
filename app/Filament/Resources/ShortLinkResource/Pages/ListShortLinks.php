<?php

namespace App\Filament\Resources\ShortLinkResource\Pages;

use App\Filament\Resources\ShortLinkResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListShortLinks extends ListRecords
{
    protected static string $resource = ShortLinkResource::class;

    public function getTitle(): string
    {
        return 'Короткие ссылки';
    }

    public function getBreadcrumbs(): array
    {
        return [
            ShortLinkResource::getUrl() => 'Список ссылок',
        ];
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->label('Создать короткую ссылку'),

        ];
    }

}
