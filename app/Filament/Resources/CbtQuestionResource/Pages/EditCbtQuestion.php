<?php

namespace App\Filament\Resources\CbtQuestionResource\Pages;

use App\Filament\Resources\CbtQuestionResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCbtQuestion extends EditRecord
{
    protected static string $resource = CbtQuestionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
