<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SettingResource\Pages;
use App\Models\Setting;
use BackedEnum;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class SettingResource extends Resource
{
    protected static ?string $model = Setting::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCog;

    protected static ?string $navigationLabel = 'Pengaturan';

    protected static ?string $modelLabel = 'Pengaturan';

    protected static ?string $pluralModelLabel = 'Pengaturan';

    protected static ?int $navigationSort = 99;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Identitas Kampus')
                    ->schema([
                        TextInput::make('university_name')
                            ->label('Nama Universitas (Lengkap)')
                            ->required()
                            ->maxLength(255)
                            ->helperText('Contoh: Sekolah Tinggi Teknologi Pratama Adi')
                            ->default(fn () => Setting::get('university_name', 'Sekolah Tinggi Teknologi Pratama Adi')),
                        
                        TextInput::make('university_short_name')
                            ->label('Nama Universitas (Singkat)')
                            ->required()
                            ->maxLength(100)
                            ->helperText('Contoh: STT Pratama Adi')
                            ->default(fn () => Setting::get('university_short_name', 'STT Pratama Adi')),
                        
                        FileUpload::make('logo')
                            ->label('Logo')
                            ->image()
                            ->directory('settings')
                            ->imageEditor()
                            ->maxSize(2048)
                            ->disk('public')
                            ->visibility('public'),
                        
                        Textarea::make('address')
                            ->label('Alamat')
                            ->rows(3)
                            ->maxLength(500)
                            ->default(fn () => Setting::get('address')),
                        
                        TextInput::make('phone')
                            ->label('Telepon')
                            ->tel()
                            ->maxLength(20)
                            ->default(fn () => Setting::get('phone')),
                        
                        TextInput::make('email')
                            ->label('Email')
                            ->email()
                            ->maxLength(255)
                            ->default(fn () => Setting::get('email')),
                    ])
                    ->columns(2),

                Section::make('Social Media')
                    ->schema([
                        TextInput::make('facebook_url')
                            ->label('Facebook URL')
                            ->url()
                            ->maxLength(255)
                            ->placeholder('https://facebook.com/sttpratama')
                            ->default(fn () => Setting::get('facebook_url')),
                        
                        TextInput::make('instagram_url')
                            ->label('Instagram URL')
                            ->url()
                            ->maxLength(255)
                            ->placeholder('https://instagram.com/sttpratama')
                            ->default(fn () => Setting::get('instagram_url')),
                        
                        TextInput::make('youtube_url')
                            ->label('YouTube URL')
                            ->url()
                            ->maxLength(255)
                            ->placeholder('https://youtube.com/@sttpratama')
                            ->default(fn () => Setting::get('youtube_url')),
                    ])
                    ->columns(3),

                Section::make('WhatsApp Admin')
                    ->schema([
                        TextInput::make('wa_admin')
                            ->label('Nomor WhatsApp Admin')
                            ->required()
                            ->tel()
                            ->maxLength(20)
                            ->placeholder('628123456789')
                            ->helperText('Format: 628123456789 (tanpa tanda + atau spasi)')
                            ->default(fn () => Setting::get('wa_admin')),
                    ])
                    ->columns(1),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('key')
                    ->label('Key')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('value')
                    ->label('Value')
                    ->limit(50)
                    ->searchable(),
                TextColumn::make('updated_at')
                    ->label('Terakhir Diupdate')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                //
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageSettings::route('/'),
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

