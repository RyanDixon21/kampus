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
                Section::make('Tentang Kami')
                    ->schema([
                        Forms\Components\TextInput::make('tentang_title')
                            ->label('Judul')
                            ->default(fn () => About::bySection('tentang')->first()?->title ?? 'Tentang Kami')
                            ->required(),
                        
                        Forms\Components\RichEditor::make('tentang_content')
                            ->label('Konten')
                            ->default(fn () => About::bySection('tentang')->first()?->content ?? '')
                            ->required()
                            ->columnSpanFull(),
                    ]),

                Section::make('Visi')
                    ->schema([
                        Forms\Components\TextInput::make('visi_title')
                            ->label('Judul')
                            ->default(fn () => About::bySection('visi')->first()?->title ?? 'Visi')
                            ->required(),
                        
                        Forms\Components\RichEditor::make('visi_content')
                            ->label('Konten')
                            ->default(fn () => About::bySection('visi')->first()?->content ?? '')
                            ->required()
                            ->columnSpanFull(),
                    ]),

                Section::make('Misi')
                    ->schema([
                        Forms\Components\TextInput::make('misi_title')
                            ->label('Judul')
                            ->default(fn () => About::bySection('misi')->first()?->title ?? 'Misi')
                            ->required(),
                        
                        Forms\Components\RichEditor::make('misi_content')
                            ->label('Konten')
                            ->default(fn () => About::bySection('misi')->first()?->content ?? '')
                            ->required()
                            ->columnSpanFull(),
                    ]),

                Section::make('Sejarah')
                    ->schema([
                        Forms\Components\TextInput::make('sejarah_title')
                            ->label('Judul')
                            ->default(fn () => About::bySection('sejarah')->first()?->title ?? 'Sejarah')
                            ->required(),
                        
                        Forms\Components\RichEditor::make('sejarah_content')
                            ->label('Konten')
                            ->default(fn () => About::bySection('sejarah')->first()?->content ?? '')
                            ->required()
                            ->columnSpanFull(),
                    ]),
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
