<?php

namespace App\Filament\Resources\ShortLinkResource\Pages;

use App\Filament\Resources\ShortLinkResource;
use App\Models\Click;
use App\Models\ShortLink;

use Filament\Resources\Pages\Page;

use Filament\Tables;
use Filament\Tables\Table;

use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Concerns\InteractsWithTable;

class ViewStatistics extends Page implements HasTable
{
    use InteractsWithTable;

    protected static string $resource = ShortLinkResource::class;

    protected static string $view =
        'filament.resources.short-link-resource.pages.view-statistics';

    public ShortLink $record;

    public function mount(ShortLink $record): void
    {
        $this->record = $record;
    }

    public function getTitle(): string
    {
        return 'Просмотр статистики ссылки';
    }
    public function getBreadcrumbs(): array
    {
        return [
            ShortLinkResource::getUrl() => 'Список ссылок','Просмотр статистики ссылки',
        ];
    }
    public function table(Table $table): Table
    {
        return $table

            ->query(
                Click::query()
                    ->where('short_link_id', $this->record->id)
            )

            ->defaultSort('clicked_at', 'desc')

            ->columns([

                Tables\Columns\TextColumn::make('ip_address')
                    ->label('IP-адрес')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('clicked_at')
                    ->label('Дата перехода по ссылке')
                    ->dateTime('d.m.Y H:i:s')
                    ->sortable(),

                // Tables\Columns\TextColumn::make('referer')
                //     ->label('Источник')
                //     ->limit(40)
                //     ->searchable(),

                Tables\Columns\TextColumn::make('user_agent')
                    ->label('Браузер')
                    ->limit(60)
                    ->toggleable(),

                // Tables\Columns\TextColumn::make('country')
                //     ->label('Страна')
                //     ->toggleable(),

            ])

            ->filters([

            ])

            ->actions([

            ])

            ->bulkActions([

            ]);
    }
}
