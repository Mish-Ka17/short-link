<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ShortLinkResource\Pages;
use App\Models\ShortLink;
use Illuminate\Database\Eloquent\Builder;

use Filament\Forms;
use Filament\Tables;

use Filament\Forms\Form;
use Filament\Tables\Table;

use Filament\Resources\Resource;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\DateTimePicker;

use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;

class ShortLinkResource extends Resource
{
    protected static ?string $model = ShortLink::class;

    protected static ?string $navigationIcon = 'heroicon-o-link';

    protected static ?string $navigationLabel = 'Короткие ссылки';

    protected static ?string $pluralModelLabel = 'Короткие ссылки';

    protected static ?string $modelLabel = 'Короткая ссылка';

    // выбор пользователя
    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()

            ->where('user_id', auth()->id());
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                TextInput::make('title')
                    ->label('Название')
                    ->maxLength(255),

                TextInput::make('original_url')
                    ->label('Оригинальный URL')
                    ->url()
                    ->required(),

                Toggle::make('is_active')
                    ->label('Активна')
                    ->default(true),

                DateTimePicker::make('expires_at')
                    ->label('Действительна до...')
                    ->seconds(false),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([

                TextColumn::make('title')
                    ->label('Название')
                    ->limit(10)
                    ->tooltip(fn ($record) => $record->title)
                    ->sortable()
                    ->searchable(),

                TextColumn::make('original_url')
                    ->label('Оригинальный URL')
                    ->limit(40)
                    ->tooltip(fn ($record) => $record->original_url)
                    ->sortable()
                    ->searchable(),

                // TextColumn::make('short_code')
                //     ->label('Код')
                //     ->copyable()
                //     ->url(fn ($record) => $record->short_url)
                //     ->openUrlInNewTab(),

                TextColumn::make('short_url')
                    ->label('Короткая ссылка')
                    ->copyable()
                    ->copyMessage('Ссылка скопирована')
                    ->copyMessageDuration(1500)
                    ->url(fn ($record) => $record->short_url)
                    ->openUrlInNewTab(),

                TextColumn::make('clicks_count')
                    ->counts('clicks')
                    ->label('Кликов')
                    ->limit(20),

                IconColumn::make('is_active')
                    ->label('Активна')
                    ->boolean(),

                TextColumn::make('created_at')
                    ->label('Создана')
                    ->limit(10)
                    ->sortable()
                    ->searchable()
                    ->tooltip(fn ($record) => $record->created_at->format('d.m.Y H:i:s'))
                    ->dateTime('d.m.Y H:i'),

            ])
            ->filters([
            ])
            ->actions([

                Tables\Actions\EditAction::make()
                    ->label('Редактировать'),



                Tables\Actions\DeleteAction::make()
                    ->label('Удалить')
                    ->modalHeading('Удаление ссылки')
                    ->modalDescription('Вы действительно хотите удалить эту короткую ссылку? Это действие необратимо!')
                    ->modalSubmitActionLabel('Удалить')
                    ->modalCancelActionLabel('Отмена'),

                Tables\Actions\Action::make('statistics')
                        ->label('Статистика')
                        ->icon('heroicon-o-chart-bar')
                        ->url(fn (ShortLink $record) =>
                            static::getUrl('statistics', [
                                'record' => $record,
                                ])
                             ),
            ])
            ->bulkActions([

                Tables\Actions\DeleteBulkAction::make(),

            ]);
    }
    public static function getPages(): array
    {
        return [

            'index' => Pages\ListShortLinks::route('/'),

            'create' => Pages\CreateShortLink::route('/create'),

            'edit' => Pages\EditShortLink::route('/{record}/edit'),

            'statistics' => Pages\ViewStatistics::route('/{record}/statistics'),
        ];
    }

}
