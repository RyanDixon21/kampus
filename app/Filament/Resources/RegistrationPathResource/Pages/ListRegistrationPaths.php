<?php

namespace App\Filament\Resources\RegistrationPathResource\Pages;

use App\Filament\Resources\RegistrationPathResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListRegistrationPaths extends ListRecords
{
    protected static string $resource = RegistrationPathResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
