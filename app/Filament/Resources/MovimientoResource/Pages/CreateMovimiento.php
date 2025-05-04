<?php

namespace App\Filament\Resources\MovimientoResource\Pages;

use App\Filament\Resources\MovimientoResource;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;

class CreateMovimiento extends CreateRecord
{
    protected static string $resource = MovimientoResource::class;

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
            ->title('Movimiento financiero Creado')
            ->body('El movimiento ha sido exitosamente agregado')
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
