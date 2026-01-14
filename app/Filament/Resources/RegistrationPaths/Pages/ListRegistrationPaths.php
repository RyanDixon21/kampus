<?php

namespace App\Filament\Resources\RegistrationPaths\Pages;

use App\Filament\Resources\RegistrationPaths\RegistrationPathResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListRegistrationPaths extends ListRecords
{
    protected static string $resource = RegistrationPathResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
