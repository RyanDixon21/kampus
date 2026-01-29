<?php

namespace App\Filament\Resources\WhyChooseUs\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class WhyChooseUsForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->label('Judul')
                    ->required()
                    ->maxLength(255),
                
                Textarea::make('description')
                    ->label('Deskripsi')
                    ->required()
                    ->rows(3)
                    ->maxLength(500),
                
                Select::make('icon')
                    ->label('Icon')
                    ->required()
                    ->options([
                        'badge' => '🏅 Badge (Akreditasi/Sertifikat)',
                        'shield' => '🛡️ Shield (Keamanan/Standar)',
                        'sparkles' => '✨ Sparkles (Penghargaan/Prestasi)',
                        'award' => '🏆 Award (Medali/Juara)',
                        'check-circle' => '✅ Check Circle (Verifikasi/Approved)',
                        'academic-cap' => '🎓 Academic Cap (Pendidikan/Akademik)',
                        'star-badge' => '⭐ Star Badge (Bintang/Excellence)',
                    ])
                    ->searchable()
                    ->native(false),
                
                Select::make('color')
                    ->label('Warna')
                    ->required()
                    ->options([
                        'blue' => 'Biru (Blue)',
                        'green' => 'Hijau (Green)',
                        'purple' => 'Ungu (Purple)',
                        'red' => 'Merah (Red)',
                        'yellow' => 'Kuning (Yellow)',
                        'indigo' => 'Indigo',
                        'pink' => 'Pink',
                        'orange' => 'Orange',
                    ])
                    ->default('blue')
                    ->native(false),
                
                TextInput::make('order')
                    ->label('Urutan')
                    ->numeric()
                    ->default(0)
                    ->required(),
                
                Toggle::make('is_active')
                    ->label('Aktif')
                    ->default(true),
            ]);
    }
}
