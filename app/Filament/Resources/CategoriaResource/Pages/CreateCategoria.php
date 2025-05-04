<?php

namespace App\Filament\Resources\CategoriaResource\Pages;

use App\Filament\Resources\CategoriaResource;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;

class CreateCategoria extends CreateRecord
{
    protected static string $resource = CategoriaResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getCreatedNotification(): ?Notification
    {
        return null;
    }

    protected function afterCreate()
    {
        Notification::make()
            ->title('Categoría Creada')
            ->body('La categoría ha sido creada exitosamente')
            ->success()
            ->send();
    }

    protected function getFormActions(): array
    {
        return[
            $this->getCreateFormAction()
                ->label('Registrar'),
            //$this->getCreateAnotherFormAction()
            //    ->label('Guardar y Nuevo'),
            $this->getCancelFormAction()
                ->label('Cancelar'),
        ];
    }
}
