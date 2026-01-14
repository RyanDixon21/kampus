<?php

namespace App\Filament\Resources\RegistrationPaths\Pages;

use App\Filament\Resources\RegistrationPaths\RegistrationPathResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditRegistrationPath extends EditRecord
{
    protected static string $resource = RegistrationPathResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
