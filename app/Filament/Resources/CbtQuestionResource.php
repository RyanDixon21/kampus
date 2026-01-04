<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CbtQuestionResource\Pages;
use App\Models\CbtQuestion;
use BackedEnum;
use Filament\Actions;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\Repeater;
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

class CbtQuestionResource extends Resource
{
    protected static ?string $model = CbtQuestion::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedAcademicCap;

    protected static ?string $navigationLabel = 'Soal CBT';

    protected static ?string $modelLabel = 'Soal CBT';

    protected static ?string $pluralModelLabel = 'Soal CBT';

    protected static ?int $navigationSort = 6;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Textarea::make('question')
                    ->label('Pertanyaan')
                    ->required()
                    ->rows(4)
                    ->columnSpanFull(),

                Repeater::make('options')
                    ->label('Pilihan Jawaban')
                    ->schema([
                        TextInput::make('text')
                            ->label('Teks Jawaban')
                            ->required()
                            ->columnSpan(2),

                        Checkbox::make('is_correct')
                            ->label('Jawaban Benar')
                            ->columnSpan(1),
                    ])
                    ->columns(3)
                    ->minItems(4)
                    ->maxItems(5)
                    ->defaultItems(4)
                    ->required()
                    ->columnSpanFull()
                    ->itemLabel(fn (array $state): ?string => $state['text'] ?? null),

                Select::make('category')
                    ->label('Kategori')
                    ->options([
                        'matematika' => 'Matematika',
                        'bahasa_inggris' => 'Bahasa Inggris',
                        'logika' => 'Logika',
                        'pengetahuan_umum' => 'Pengetahuan Umum',
                    ])
                    ->required(),

                Toggle::make('is_active')
                    ->label('Aktif')
                    ->default(true)
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('question')
                    ->label('Pertanyaan')
                    ->searchable()
                    ->sortable()
                    ->limit(80)
                    ->wrap(),

                TextColumn::make('category')
                    ->label('Kategori')
                    ->sortable()
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'matematika' => 'Matematika',
                        'bahasa_inggris' => 'Bahasa Inggris',
                        'logika' => 'Logika',
                        'pengetahuan_umum' => 'Pengetahuan Umum',
                        default => $state,
                    })
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'matematika' => 'info',
                        'bahasa_inggris' => 'success',
                        'logika' => 'warning',
                        'pengetahuan_umum' => 'gray',
                        default => 'gray',
                    }),

                IconColumn::make('is_active')
                    ->label('Aktif')
                    ->boolean()
                    ->sortable(),

                TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d M Y, H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('category')
                    ->label('Kategori')
                    ->options([
                        'matematika' => 'Matematika',
                        'bahasa_inggris' => 'Bahasa Inggris',
                        'logika' => 'Logika',
                        'pengetahuan_umum' => 'Pengetahuan Umum',
                    ]),

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
                Actions\BulkActionGroup::make([
                    Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCbtQuestions::route('/'),
            'create' => Pages\CreateCbtQuestion::route('/create'),
            'edit' => Pages\EditCbtQuestion::route('/{record}/edit'),
        ];
    }
}
