<?php

namespace App\Filament\Resources\CbtQuestionResource\Pages;

use App\Filament\Resources\CbtQuestionResource;
use Filament\Resources\Pages\ListRecords;

class ListCbtQuestions extends ListRecords
{
    protected static string $resource = CbtQuestionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            \Filament\Actions\CreateAction::make(),
        ];
    }
}
