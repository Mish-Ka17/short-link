<?php

namespace App\Filament\Resources\ShortLinkResource\Pages;

use App\Filament\Resources\ShortLinkResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Filament\Notifications\Notification;

class CreateShortLink extends CreateRecord
{
    protected static string $resource = ShortLinkResource::class;

    public function getTitle(): string
    {
        return 'Создание короткой ссылки';
    }
    public function getBreadcrumbs(): array
    {
        return [
            ShortLinkResource::getUrl() => 'Список ссылок', 'Создание короткой ссылки',
        ];
    }
    //определение названий кнопок
    protected function getCancelFormAction(): \Filament\Actions\Action
    {
        return parent::getCancelFormAction()
            ->label('Отмена');
    }
    protected function getcreateFormAction(): \Filament\Actions\Action
    {
        return parent::getCreateFormAction()
            ->label('Создать');
    }
protected function getCreatedNotification(): ?Notification
    {
        return Notification::make()
            ->success()
            ->title('Готово!')
            ->body('Короткая ссылка успешно создана.');
    }

    protected function getCreateAnotherFormAction(): \Filament\Actions\Action
{
    return parent::getCreateAnotherFormAction()
        ->label('Создать и добавить ещё');
}


}
