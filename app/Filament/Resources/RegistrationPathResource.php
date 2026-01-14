<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RegistrationPathResource\Pages;
use App\Models\RegistrationPath;
use App\Models\StudyProgram;
use BackedEnum;
use Filament\Actions;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use UnitEnum;

class RegistrationPathResource extends Resource
{
    protected static ?string $model = RegistrationPath::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedMapPin;

    protected static ?string $navigationLabel = 'Jalur Pendaftaran';

    protected static ?string $modelLabel = 'Jalur Pendaftaran';

    protected static ?string $pluralModelLabel = 'Jalur Pendaftaran';

    protected static UnitEnum|string|null $navigationGroup = 'Pendaftaran';

    protected static ?int $navigationSort = 2;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Nama Jalur')
                    ->required()
                    ->maxLength(255)
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn ($state, callable $set) => $set('slug', Str::slug($state))),

                TextInput::make('slug')
                    ->label('Slug')
                    ->required()
                    ->maxLength(255)
                    ->unique(ignoreRecord: true)
                    ->helperText('URL-friendly version dari nama jalur'),

                Select::make('system_type')
                    ->label('Tipe Sistem')
                    ->options([
                        'regular' => 'Reguler',
                        'prestasi' => 'Prestasi',
                        'pmdk' => 'PMDK',
                    ])
                    ->required(),

                Select::make('degree_level')
                    ->label('Jenjang')
                    ->options([
                        'S1' => 'Sarjana (S1)',
                        'D3' => 'Diploma (D3)',
                        'S2' => 'Magister (S2)',
                    ])
                    ->required(),

                TextInput::make('wave')
                    ->label('Gelombang')
                    ->maxLength(50)
                    ->placeholder('Contoh: Gelombang 1'),

                TextInput::make('period')
                    ->label('Periode')
                    ->maxLength(50)
                    ->placeholder('Contoh: 2025/2026'),

                Textarea::make('description')
                    ->label('Deskripsi')
                    ->rows(3)
                    ->columnSpanFull(),

                TextInput::make('registration_fee')
                    ->label('Biaya Pendaftaran')
                    ->required()
                    ->numeric()
                    ->prefix('Rp')
                    ->helperText('Masukkan angka tanpa titik atau koma'),

                TextInput::make('quota')
                    ->label('Kuota')
                    ->numeric()
                    ->helperText('Kosongkan untuk kuota tidak terbatas'),

                DateTimePicker::make('start_date')
                    ->label('Tanggal Mulai')
                    ->required()
                    ->native(false),

                DateTimePicker::make('end_date')
                    ->label('Tanggal Selesai')
                    ->required()
                    ->native(false)
                    ->after('start_date'),

                Toggle::make('is_active')
                    ->label('Aktif')
                    ->default(true)
                    ->helperText('Jalur pendaftaran hanya bisa dipilih jika aktif'),

                Select::make('studyPrograms')
                    ->label('Program Studi')
                    ->relationship('studyPrograms', 'name')
                    ->multiple()
                    ->preload()
                    ->searchable()
                    ->columnSpanFull()
                    ->helperText('Pilih program studi yang tersedia untuk jalur ini'),

                KeyValue::make('requirements')
                    ->label('Persyaratan')
                    ->keyLabel('Nama Persyaratan')
                    ->valueLabel('Keterangan')
                    ->columnSpanFull()
                    ->helperText('Daftar persyaratan untuk jalur pendaftaran ini'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Nama Jalur')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                TextColumn::make('degree_level')
                    ->label('Jenjang')
                    ->badge()
                    ->color(fn (?string $state): string => match ($state) {
                        'S1' => 'success',
                        'D3' => 'info',
                        'S2' => 'warning',
                        default => 'gray',
                    })
                    ->sortable(),

                TextColumn::make('system_type')
                    ->label('Tipe')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'regular' => 'primary',
                        'prestasi' => 'success',
                        'pmdk' => 'warning',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'regular' => 'Reguler',
                        'prestasi' => 'Prestasi',
                        'pmdk' => 'PMDK',
                        default => $state,
                    }),

                TextColumn::make('wave')
                    ->label('Gelombang')
                    ->searchable()
                    ->toggleable(),

                TextColumn::make('period')
                    ->label('Periode')
                    ->searchable()
                    ->toggleable(),

                TextColumn::make('registration_fee')
                    ->label('Biaya')
                    ->money('IDR')
                    ->sortable(),

                TextColumn::make('start_date')
                    ->label('Mulai')
                    ->dateTime('d M Y')
                    ->sortable(),

                TextColumn::make('end_date')
                    ->label('Selesai')
                    ->dateTime('d M Y')
                    ->sortable(),

                TextColumn::make('quota')
                    ->label('Kuota')
                    ->default('Unlimited')
                    ->sortable(),

                TextColumn::make('studyPrograms.name')
                    ->label('Program Studi')
                    ->listWithLineBreaks()
                    ->limitList(2)
                    ->expandableLimitedList()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('registrations_count')
                    ->label('Pendaftar')
                    ->counts('registrations')
                    ->sortable(),

                IconColumn::make('is_active')
                    ->label('Status')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('danger'),
            ])
            ->filters([
                SelectFilter::make('degree_level')
                    ->label('Jenjang')
                    ->options([
                        'S1' => 'Sarjana (S1)',
                        'D3' => 'Diploma (D3)',
                        'S2' => 'Magister (S2)',
                    ]),

                SelectFilter::make('system_type')
                    ->label('Tipe Sistem')
                    ->options([
                        'regular' => 'Reguler',
                        'prestasi' => 'Prestasi',
                        'pmdk' => 'PMDK',
                    ]),

                SelectFilter::make('is_active')
                    ->label('Status')
                    ->options([
                        1 => 'Aktif',
                        0 => 'Tidak Aktif',
                    ]),
            ])
            ->actions([
                Actions\ViewAction::make(),
                Actions\EditAction::make(),
            ])
            ->bulkActions([
                Actions\DeleteBulkAction::make(),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListRegistrationPaths::route('/'),
            'create' => Pages\CreateRegistrationPath::route('/create'),
            'edit' => Pages\EditRegistrationPath::route('/{record}/edit'),
            'view' => Pages\ViewRegistrationPath::route('/{record}'),
        ];
    }
}
