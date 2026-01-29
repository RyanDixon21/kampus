<?php

namespace App\Filament\Resources;

use App\Filament\Resources\StudyProgramResource\Pages;
use App\Models\StudyProgram;
use BackedEnum;
use Filament\Actions;
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
use UnitEnum;

class StudyProgramResource extends Resource
{
    protected static ?string $model = StudyProgram::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedAcademicCap;

    protected static ?string $navigationLabel = 'Program Studi';

    protected static ?string $modelLabel = 'Program Studi';

    protected static ?string $pluralModelLabel = 'Program Studi';

    protected static UnitEnum|string|null $navigationGroup = 'Pendaftaran';

    protected static ?int $navigationSort = 3;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Nama Program Studi')
                    ->required()
                    ->maxLength(255),

                TextInput::make('code')
                    ->label('Kode Program Studi')
                    ->required()
                    ->maxLength(50)
                    ->unique(ignoreRecord: true)
                    ->helperText('Kode unik untuk program studi'),

                TextInput::make('faculty')
                    ->label('Fakultas')
                    ->maxLength(255)
                    ->helperText('Contoh: Fakultas Ilmu Sosial dan Politik'),

                Select::make('degree_level')
                    ->label('Jenjang')
                    ->options([
                        'D3' => 'D3 (Diploma 3)',
                        'S1' => 'S1 (Sarjana)',
                        'S2' => 'S2 (Magister)',
                        'S3' => 'S3 (Doktor)',
                    ])
                    ->required(),

                Textarea::make('description')
                    ->label('Deskripsi')
                    ->rows(3)
                    ->columnSpanFull(),

                Toggle::make('is_active')
                    ->label('Aktif')
                    ->default(true)
                    ->helperText('Program studi hanya bisa dipilih jika aktif'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('code')
                    ->label('Kode')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                TextColumn::make('name')
                    ->label('Nama Program Studi')
                    ->searchable()
                    ->sortable()
                    ->limit(50),

                TextColumn::make('faculty')
                    ->label('Fakultas')
                    ->searchable()
                    ->sortable()
                    ->limit(40)
                    ->toggleable(),

                TextColumn::make('degree_level')
                    ->label('Jenjang')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'D3' => 'info',
                        'S1' => 'success',
                        'S2' => 'warning',
                        'S3' => 'danger',
                        default => 'gray',
                    })
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
                        'D3' => 'D3',
                        'S1' => 'S1',
                        'S2' => 'S2',
                        'S3' => 'S3',
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
            ->defaultSort('code', 'asc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListStudyPrograms::route('/'),
            'create' => Pages\CreateStudyProgram::route('/create'),
            'edit' => Pages\EditStudyProgram::route('/{record}/edit'),
            'view' => Pages\ViewStudyProgram::route('/{record}'),
        ];
    }
}
