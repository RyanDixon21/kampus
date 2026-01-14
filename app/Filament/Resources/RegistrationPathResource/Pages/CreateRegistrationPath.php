<?php

namespace App\Filament\Resources\RegistrationPathResource\Pages;

use App\Filament\Resources\RegistrationPathResource;
use Filament\Resources\Pages\CreateRecord;

class CreateRegistrationPath extends CreateRecord
{
    protected static string $resource = RegistrationPathResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
