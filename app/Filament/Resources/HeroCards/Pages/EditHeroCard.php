<?php

namespace App\Filament\Resources\HeroCards\Pages;

use App\Filament\Resources\HeroCards\HeroCardResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditHeroCard extends EditRecord
{
    protected static string $resource = HeroCardResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
