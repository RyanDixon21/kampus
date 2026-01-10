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
                        'book-open' => '📖 Buku (Book Open)',
                        'academic-cap' => '🎓 Topi Wisuda (Academic Cap)',
                        'briefcase' => '💼 Tas Kerja (Briefcase)',
                        'users' => '👥 Pengguna (Users)',
                        'building-library' => '🏛️ Perpustakaan (Library)',
                        'beaker' => '🧪 Lab (Beaker)',
                        'computer-desktop' => '💻 Komputer (Computer)',
                        'light-bulb' => '💡 Lampu (Light Bulb)',
                        'trophy' => '🏆 Trofi (Trophy)',
                        'star' => '⭐ Bintang (Star)',
                        'rocket-launch' => '🚀 Roket (Rocket)',
                        'shield-check' => '🛡️ Perisai (Shield)',
                        'chart-bar' => '📊 Grafik (Chart)',
                        'globe-alt' => '🌍 Globe (Globe)',
                        'cog' => '⚙️ Pengaturan (Cog)',
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
