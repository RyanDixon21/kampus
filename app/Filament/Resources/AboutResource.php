<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AboutResource\Pages;
use App\Models\About;
use BackedEnum;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;

class AboutResource extends Resource
{
    protected static ?string $model = About::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedInformationCircle;

    protected static ?string $navigationLabel = 'Tentang';

    protected static ?int $navigationSort = 2;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Sejarah')
                    ->schema([
                        Forms\Components\TextInput::make('sejarah_title')
                            ->label('Judul')
                            ->default(fn () => About::bySection('sejarah')->first()?->title ?? 'Sejarah Kami')
                            ->required(),
                        
                        Forms\Components\Textarea::make('sejarah_content')
                            ->label('Konten')
                            ->default(fn () => About::bySection('sejarah')->first()?->content ?? '')
                            ->required()
                            ->rows(6)
                            ->columnSpanFull(),
                    ]),

                Section::make('Visi')
                    ->schema([
                        Forms\Components\Textarea::make('visi_content')
                            ->label('Konten Visi')
                            ->default(fn () => About::bySection('visi')->first()?->content ?? '')
                            ->required()
                            ->rows(4)
                            ->columnSpanFull(),
                    ]),

                Section::make('Misi')
                    ->description('Masukkan setiap misi dalam baris terpisah')
                    ->schema([
                        Forms\Components\Textarea::make('misi_content')
                            ->label('Daftar Misi')
                            ->default(fn () => About::bySection('misi')->first()?->content ?? '')
                            ->required()
                            ->rows(6)
                            ->columnSpanFull()
                            ->helperText('Pisahkan setiap misi dengan enter/baris baru'),
                    ]),

                Section::make('Nilai-Nilai')
                    ->schema([
                        Forms\Components\TextInput::make('nilai_title')
                            ->label('Judul Section')
                            ->default(fn () => About::bySection('nilai_header')->first()?->title ?? 'Nilai-Nilai Kami')
                            ->required(),
                        
                        Forms\Components\Textarea::make('nilai_description')
                            ->label('Deskripsi Section')
                            ->default(fn () => About::bySection('nilai_header')->first()?->content ?? 'Prinsip yang menjadi landasan dalam setiap kegiatan kami')
                            ->required()
                            ->rows(2),
                        
                        Forms\Components\Repeater::make('nilai_items')
                            ->label('Daftar Nilai')
                            ->schema([
                                Forms\Components\Select::make('icon')
                                    ->label('Icon')
                                    ->options([
                                        'shield' => 'Shield (Perlindungan/Integritas)',
                                        'lightbulb' => 'Lightbulb (Inovasi/Ide)',
                                        'star' => 'Star (Keunggulan/Prestasi)',
                                        'users' => 'Users (Kolaborasi/Tim)',
                                        'heart' => 'Heart (Kepedulian/Empati)',
                                        'rocket' => 'Rocket (Kemajuan/Pertumbuhan)',
                                        'trophy' => 'Trophy (Pencapaian/Juara)',
                                    ])
                                    ->required(),
                                Forms\Components\TextInput::make('title')
                                    ->label('Judul Nilai')
                                    ->required(),
                                Forms\Components\Textarea::make('content')
                                    ->label('Deskripsi')
                                    ->required()
                                    ->rows(2),
                            ])
                            ->defaultItems(0)
                            ->maxItems(4)
                            ->columnSpanFull()
                            ->default(function () {
                                $nilai = About::bySection('nilai')->ordered()->get();
                                return $nilai->map(fn($item) => [
                                    'icon' => $item->order == 1 ? 'shield' : ($item->order == 2 ? 'lightbulb' : ($item->order == 3 ? 'star' : 'users')),
                                    'title' => $item->title,
                                    'content' => $item->content,
                                ])->toArray();
                            }),
                    ]),

                Section::make('Akreditasi & Penghargaan')
                    ->schema([
                        Forms\Components\TextInput::make('akreditasi_title')
                            ->label('Judul Section')
                            ->default(fn () => About::bySection('akreditasi_header')->first()?->title ?? 'Akreditasi & Penghargaan')
                            ->required(),
                        
                        Forms\Components\Textarea::make('akreditasi_description')
                            ->label('Deskripsi Section')
                            ->default(fn () => About::bySection('akreditasi_header')->first()?->content ?? 'Pengakuan atas komitmen kami terhadap kualitas pendidikan')
                            ->required()
                            ->rows(2),
                        
                        Forms\Components\Repeater::make('akreditasi_items')
                            ->label('Daftar Akreditasi & Penghargaan')
                            ->schema([
                                Forms\Components\Select::make('icon')
                                    ->label('Icon')
                                    ->options([
                                        'badge' => 'Badge (Akreditasi/Sertifikat)',
                                        'shield' => 'Shield (Keamanan/Standar)',
                                        'sparkles' => 'Sparkles (Penghargaan/Prestasi)',
                                        'award' => 'Award (Medali/Juara)',
                                        'check-circle' => 'Check Circle (Verifikasi/Approved)',
                                        'academic-cap' => 'Academic Cap (Pendidikan/Akademik)',
                                        'star-badge' => 'Star Badge (Bintang/Excellence)',
                                    ])
                                    ->required(),
                                Forms\Components\TextInput::make('title')
                                    ->label('Judul')
                                    ->required(),
                                Forms\Components\Textarea::make('content')
                                    ->label('Deskripsi')
                                    ->required()
                                    ->rows(2),
                            ])
                            ->defaultItems(0)
                            ->maxItems(3)
                            ->columnSpanFull()
                            ->default(function () {
                                $akreditasi = About::bySection('akreditasi')->ordered()->get();
                                return $akreditasi->map(fn($item) => [
                                    'icon' => $item->icon ?? ($item->order == 1 ? 'badge' : ($item->order == 2 ? 'shield' : 'sparkles')),
                                    'title' => $item->title,
                                    'content' => $item->content,
                                ])->toArray();
                            }),
                    ]),

                Section::make('Call to Action (CTA)')
                    ->schema([
                        Forms\Components\TextInput::make('cta_title')
                            ->label('Judul CTA')
                            ->default(fn () => About::bySection('cta')->first()?->title ?? 'Siap Bergabung Bersama Kami?')
                            ->required(),
                        
                        Forms\Components\Textarea::make('cta_description')
                            ->label('Deskripsi CTA')
                            ->default(fn () => About::bySection('cta')->first()?->content ?? 'Wujudkan impian Anda untuk menjadi profesional di bidang teknologi')
                            ->required()
                            ->rows(2),
                        
                        Forms\Components\TextInput::make('cta_button_text')
                            ->label('Teks Button')
                            ->default(fn () => About::bySection('cta_button')->first()?->title ?? 'Daftar Sekarang')
                            ->required(),
                        
                        Forms\Components\TextInput::make('cta_button_link')
                            ->label('Link Button')
                            ->default(fn () => About::bySection('cta_button')->first()?->content ?? route('registration.search'))
                            ->required()
                            ->helperText('Bisa menggunakan URL lengkap (https://wa.me/...) atau path internal (/home, /tentang)'),
                    ])
                    ->columns(2),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageAbout::route('/'),
        ];
    }

    public static function canCreate(): bool
    {
        return false;
    }

    public static function getFormSchema(): array
    {
        return self::form(\Filament\Schemas\Schema::make())->getComponents();
    }
}
