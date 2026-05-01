<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AccreditationCertificateResource\Pages;
use App\Models\AccreditationCertificate;
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
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use UnitEnum;

class AccreditationCertificateResource extends Resource
{
    protected static ?string $model = AccreditationCertificate::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedDocumentText;

    protected static ?string $navigationLabel = 'Sertifikat Akreditasi';

    protected static ?string $modelLabel = 'Sertifikat Akreditasi';

    protected static ?string $pluralModelLabel = 'Sertifikat Akreditasi';

    protected static UnitEnum|string|null $navigationGroup = 'Konten Website';

    protected static ?int $navigationSort = 3;

    protected static bool $shouldRegisterNavigation = false; // Hide from sidebar

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->label('Judul Sertifikat')
                    ->maxLength(255)
                    ->helperText('Opsional - Nama atau judul sertifikat'),

                FileUpload::make('image')
                    ->label('Gambar Sertifikat')
                    ->image()
                    ->directory('certificates')
                    ->disk('public')
                    ->visibility('public')
                    ->required()
                    ->imageEditor()
                    ->imageEditorAspectRatios([
                        null,
                        '16:9',
                        '4:3',
                        '1:1',
                    ])
                    ->maxSize(5120) // 5MB
                    ->helperText('Upload gambar sertifikat (max 5MB). Klik untuk edit gambar sebelum upload.')
                    ->columnSpanFull(),

                Textarea::make('description')
                    ->label('Deskripsi')
                    ->rows(3)
                    ->maxLength(500)
                    ->helperText('Opsional - Deskripsi singkat tentang sertifikat')
                    ->columnSpanFull(),

                TextInput::make('order')
                    ->label('Urutan Tampilan')
                    ->numeric()
                    ->default(0)
                    ->required()
                    ->helperText('Semakin kecil angka, semakin awal ditampilkan'),

                Toggle::make('is_active')
                    ->label('Aktif')
                    ->default(true)
                    ->helperText('Hanya sertifikat aktif yang ditampilkan di website'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('order')
                    ->label('#')
                    ->sortable()
                    ->width(50),

                ImageColumn::make('image')
                    ->label('Gambar')
                    ->disk('public')
                    ->width(100)
                    ->height(60),

                TextColumn::make('title')
                    ->label('Judul')
                    ->searchable()
                    ->sortable()
                    ->limit(50)
                    ->placeholder('-'),

                TextColumn::make('description')
                    ->label('Deskripsi')
                    ->limit(60)
                    ->placeholder('-')
                    ->toggleable(isToggledHiddenByDefault: true),

                IconColumn::make('is_active')
                    ->label('Status')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('danger'),

                TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d M Y, H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('is_active')
                    ->label('Status')
                    ->options([
                        1 => 'Aktif',
                        0 => 'Tidak Aktif',
                    ]),
            ])
            ->actions([
                Actions\EditAction::make(),
                Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Actions\DeleteBulkAction::make(),
            ])
            ->reorderable('order')
            ->defaultSort('order', 'asc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAccreditationCertificates::route('/'),
            'create' => Pages\CreateAccreditationCertificate::route('/create'),
            'edit' => Pages\EditAccreditationCertificate::route('/{record}/edit'),
        ];
    }
}
