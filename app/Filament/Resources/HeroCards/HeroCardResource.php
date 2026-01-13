<?php

namespace App\Filament\Resources\HeroCards;

use App\Filament\Resources\HeroCards\Pages\CreateHeroCard;
use App\Filament\Resources\HeroCards\Pages\EditHeroCard;
use App\Filament\Resources\HeroCards\Pages\ListHeroCards;
use App\Models\HeroCard;
use BackedEnum;
use Filament\Actions;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use UnitEnum;

class HeroCardResource extends Resource
{
    protected static ?string $model = HeroCard::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $navigationLabel = 'Hero Slider';

    protected static ?string $modelLabel = 'Hero Slide';

    protected static ?string $pluralModelLabel = 'Hero Slides';

    protected static ?int $navigationSort = 11;

    protected static UnitEnum|string|null $navigationGroup = 'Konten';

    protected static ?string $recordTitleAttribute = 'title';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->label('Judul Utama')
                    ->required()
                    ->maxLength(255)
                    ->helperText('Contoh: Selamat Datang di')
                    ->columnSpanFull(),

                TextInput::make('subtitle')
                    ->label('Sub Judul')
                    ->required()
                    ->maxLength(255)
                    ->helperText('Contoh: Sekolah Tinggi Teknologi Pratama Adi')
                    ->columnSpanFull(),

                Textarea::make('description')
                    ->label('Deskripsi')
                    ->required()
                    ->rows(3)
                    ->maxLength(500)
                    ->helperText('Contoh: Sekolah Tinggi Teknologi Terdepan untuk Masa Depan Anda')
                    ->columnSpanFull(),

                FileUpload::make('background_image')
                    ->label('Gambar Background')
                    ->image()
                    ->directory('hero-slides')
                    ->disk('public')
                    ->visibility('public')
                    ->imageEditor()
                    ->maxSize(5120)
                    ->helperText('Ukuran rekomendasi: 1920x1080px. Format: JPG, PNG. Max: 5MB. Hapus gambar lama sebelum upload baru.')
                    ->columnSpanFull(),

                TextInput::make('button_text')
                    ->label('Teks Tombol')
                    ->maxLength(100)
                    ->default('Daftar Sekarang')
                    ->helperText('Kosongkan jika tidak ingin menampilkan tombol'),

                TextInput::make('button_link')
                    ->label('Link Tombol')
                    ->maxLength(255)
                    ->placeholder('/home, /news, /registration, atau https://example.com')
                    ->helperText('Contoh: /registration atau https://example.com')
                    ->rule(function () {
                        return function (string $attribute, $value, \Closure $fail) {
                            if (empty($value)) {
                                return;
                            }
                            
                            // Allow internal paths starting with /
                            if (str_starts_with($value, '/')) {
                                return;
                            }
                            
                            // Allow full URLs with http:// or https://
                            if (filter_var($value, FILTER_VALIDATE_URL)) {
                                return;
                            }
                            
                            $fail('Link harus berupa path internal (contoh: /home) atau URL lengkap (contoh: https://example.com)');
                        };
                    }),

                TextInput::make('order')
                    ->label('Urutan')
                    ->numeric()
                    ->default(0)
                    ->required()
                    ->helperText('Urutan tampilan slide (angka lebih kecil tampil lebih dulu)'),

                Toggle::make('is_active')
                    ->label('Aktif')
                    ->default(true)
                    ->helperText('Hanya slide aktif yang akan ditampilkan'),

                Toggle::make('show_logo')
                    ->label('Tampilkan Logo')
                    ->default(true)
                    ->helperText('Tampilkan logo kampus di slide ini'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('background_image')
                    ->label('Background')
                    ->disk('public')
                    ->square()
                    ->size(60),

                TextColumn::make('title')
                    ->label('Judul')
                    ->searchable()
                    ->sortable()
                    ->limit(30),

                TextColumn::make('subtitle')
                    ->label('Sub Judul')
                    ->searchable()
                    ->limit(30),

                TextColumn::make('order')
                    ->label('Urutan')
                    ->sortable()
                    ->alignCenter(),

                IconColumn::make('is_active')
                    ->label('Status')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('danger')
                    ->alignCenter(),

                IconColumn::make('show_logo')
                    ->label('Logo')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('danger')
                    ->alignCenter(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Actions\EditAction::make(),
                Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Actions\BulkActionGroup::make([
                    Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('order', 'asc')
            ->reorderable('order');
    }

    public static function getPages(): array
    {
        return [
            'index' => ListHeroCards::route('/'),
            'create' => CreateHeroCard::route('/create'),
            'edit' => EditHeroCard::route('/{record}/edit'),
        ];
    }
}
