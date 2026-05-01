<?php

namespace App\Filament\Resources\AccreditationCertificateResource\Pages;

use App\Filament\Resources\AccreditationCertificateResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAccreditationCertificates extends ListRecords
{
    protected static string $resource = AccreditationCertificateResource::class;

    protected static ?string $title = 'Sertifikat Akreditasi';

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Tambah Sertifikat'),
        ];
    }
}
