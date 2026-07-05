<?php

namespace App\Filament\Resources\ShortLinkResource\Pages;

use App\Filament\Resources\ShortLinkResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Filament\Notifications\Notification;


class EditShortLink extends EditRecord
{
    protected static string $resource = ShortLinkResource::class;

    public function getTitle(): string
    {
        return 'Редактирование ссылки';
    }
    public function getBreadcrumbs(): array
    {
        return [
            ShortLinkResource::getUrl() => 'Короткие ссылки',
            'Редактирование ссылки',
        ];
    }

    //переопределение кнопок
    protected function getSaveFormAction(): \Filament\Actions\Action
    {
        return parent::getSaveFormAction()
            ->label('Сохранить');
    }

    protected function getSavedNotification(): ?Notification
    {
        return Notification::make()
            ->success()
            ->title('Готово!')
            ->body('Изменения успешно сохранены.');
    }
    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make()
                ->label('Удалить ссылку')
                ->modalHeading('Удаление короткой ссылки')
                ->modalDescription('Вы действительно хотите удалить эту короткую ссылку?')
                ->modalSubmitActionLabel('Удалить')
                ->modalCancelActionLabel('Отмена')
                ->successNotificationTitle('Короткая ссылка удалена.'),
        ];
    }
    protected function getCancelFormAction(): \Filament\Actions\Action
    {
        return parent::getCancelFormAction()
            ->label('Отмена');
    }

}
