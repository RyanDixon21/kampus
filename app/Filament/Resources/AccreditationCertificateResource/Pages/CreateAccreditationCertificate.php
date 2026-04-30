<?php

namespace App\Filament\Resources\AccreditationCertificateResource\Pages;

use App\Filament\Resources\AccreditationCertificateResource;
use Filament\Resources\Pages\CreateRecord;

class CreateAccreditationCertificate extends CreateRecord
{
    protected static string $resource = AccreditationCertificateResource::class;

    protected static ?string $title = 'Tambah Sertifikat Akreditasi';

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
