<?php

namespace App\Filament\Resources\HeroCards\Pages;

use App\Filament\Resources\HeroCards\HeroCardResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListHeroCards extends ListRecords
{
    protected static string $resource = HeroCardResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
