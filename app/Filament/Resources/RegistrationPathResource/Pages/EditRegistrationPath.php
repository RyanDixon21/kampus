<?php

namespace App\Filament\Resources\RegistrationPathResource\Pages;

use App\Filament\Resources\RegistrationPathResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditRegistrationPath extends EditRecord
{
    protected static string $resource = RegistrationPathResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
