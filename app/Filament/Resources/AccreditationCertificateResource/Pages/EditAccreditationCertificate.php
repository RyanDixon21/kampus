<?php

namespace App\Filament\Resources\AccreditationCertificateResource\Pages;

use App\Filament\Resources\AccreditationCertificateResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAccreditationCertificate extends EditRecord
{
    protected static string $resource = AccreditationCertificateResource::class;

    protected static ?string $title = 'Edit Sertifikat Akreditasi';

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
