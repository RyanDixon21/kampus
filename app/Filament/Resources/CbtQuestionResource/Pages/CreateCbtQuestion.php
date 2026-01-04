<?php

namespace App\Filament\Resources\CbtQuestionResource\Pages;

use App\Filament\Resources\CbtQuestionResource;
use Filament\Resources\Pages\CreateRecord;

class CreateCbtQuestion extends CreateRecord
{
    protected static string $resource = CbtQuestionResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
