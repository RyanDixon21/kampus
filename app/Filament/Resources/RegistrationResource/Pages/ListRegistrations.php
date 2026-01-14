<?php

namespace App\Filament\Resources\RegistrationResource\Pages;

use App\Filament\Resources\RegistrationResource;
use Filament\Actions\Action;
use Filament\Resources\Pages\ListRecords;

class ListRegistrations extends ListRecords
{
    protected static string $resource = RegistrationResource::class;

    protected static ?string $title = 'Pendaftaran';

    protected function getHeaderActions(): array
    {
        return [
            Action::make('export_all')
                ->label('Export Semua Data')
                ->icon('heroicon-o-arrow-down-tray')
                ->color('success')
                ->action(function () {
                    // This will be handled by Filament's export functionality
                    return redirect()->route('filament.admin.resources.registrations.index');
                }),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            RegistrationResource\Widgets\RegistrationStatsWidget::class,
        ];
    }
}
