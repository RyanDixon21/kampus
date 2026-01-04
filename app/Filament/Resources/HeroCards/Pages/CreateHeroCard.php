<?php

namespace App\Filament\Resources\HeroCards\Pages;

use App\Filament\Resources\HeroCards\HeroCardResource;
use Filament\Resources\Pages\CreateRecord;

class CreateHeroCard extends CreateRecord
{
    protected static string $resource = HeroCardResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
