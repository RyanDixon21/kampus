<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RegistrationResource\Pages;
use App\Models\Registration;
use BackedEnum;
use Filament\Actions;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class RegistrationResource extends Resource
{
    protected static ?string $model = Registration::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedClipboardDocumentList;

    protected static ?string $navigationLabel = 'Pendaftaran';

    protected static ?string $modelLabel = 'Pendaftaran';

    protected static ?string $pluralModelLabel = 'Pendaftaran';

    protected static ?int $navigationSort = 3;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Data Diri')
                    ->schema([
                        Placeholder::make('name')
                            ->label('Nama')
                            ->content(fn (?Registration $record): string => $record?->name ?? '-'),

                        Placeholder::make('email')
                            ->label('Email')
                            ->content(fn (?Registration $record): string => $record?->email ?? '-'),

                        Placeholder::make('phone')
                            ->label('Telepon')
                            ->content(fn (?Registration $record): string => $record?->phone ?? '-'),

                        Placeholder::make('address')
                            ->label('Alamat')
                            ->content(fn (?Registration $record): string => $record?->address ?? '-')
                            ->columnSpanFull(),
                    ])
                    ->columns(2),

                Section::make('Status')
                    ->schema([
                        Placeholder::make('registration_number')
                            ->label('Nomor Pendaftaran')
                            ->content(fn (?Registration $record): string => $record?->registration_number ?? '-'),

                        Placeholder::make('status')
                            ->label('Status Pendaftaran')
                            ->content(fn (?Registration $record): string => match ($record?->status) {
                                'pending' => '🟡 Menunggu',
                                'paid' => '🟢 Lunas',
                                'cancelled' => '🔴 Dibatalkan',
                                default => '-',
                            }),

                        Placeholder::make('payment_status')
                            ->label('Status Pembayaran')
                            ->content(fn (?Registration $record): string => match ($record?->payment_status) {
                                'paid' => '🟢 Lunas',
                                'pending' => '🟡 Menunggu',
                                'failed' => '🔴 Gagal',
                                default => '-',
                            }),

                        Placeholder::make('payment_amount')
                            ->label('Jumlah Pembayaran')
                            ->content(fn (?Registration $record): string => 
                                $record?->payment_amount 
                                    ? 'Rp ' . number_format($record->payment_amount, 0, ',', '.') 
                                    : '-'
                            ),

                        Placeholder::make('payment_date')
                            ->label('Tanggal Pembayaran')
                            ->content(fn (?Registration $record): string => 
                                $record?->payment_date 
                                    ? $record->payment_date->format('d M Y, H:i') 
                                    : '-'
                            ),

                        Placeholder::make('cbt_score')
                            ->label('Skor CBT')
                            ->content(fn (?Registration $record): string => 
                                $record?->cbt_score !== null 
                                    ? $record->cbt_score . '/100' 
                                    : '-'
                            ),

                        Placeholder::make('cbt_completed_at')
                            ->label('Waktu Selesai CBT')
                            ->content(fn (?Registration $record): string => 
                                $record?->cbt_completed_at 
                                    ? $record->cbt_completed_at->format('d M Y, H:i') 
                                    : '-'
                            ),

                        Placeholder::make('created_at')
                            ->label('Tanggal Pendaftaran')
                            ->content(fn (?Registration $record): string => 
                                $record?->created_at 
                                    ? $record->created_at->format('d M Y, H:i') 
                                    : '-'
                            ),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('registration_number')
                    ->label('Nomor Pendaftaran')
                    ->searchable()
                    ->sortable()
                    ->copyable()
                    ->copyMessage('Nomor pendaftaran disalin!')
                    ->weight('bold'),

                TextColumn::make('name')
                    ->label('Nama')
                    ->searchable()
                    ->sortable()
                    ->limit(50),

                TextColumn::make('email')
                    ->label('Email')
                    ->searchable()
                    ->sortable()
                    ->limit(50),

                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'pending' => 'warning',
                        'paid' => 'success',
                        'cancelled' => 'danger',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'pending' => 'Menunggu',
                        'paid' => 'Lunas',
                        'cancelled' => 'Dibatalkan',
                        default => $state,
                    }),

                TextColumn::make('created_at')
                    ->label('Tanggal Pendaftaran')
                    ->dateTime('d M Y, H:i')
                    ->sortable(),

                TextColumn::make('cbt_score')
                    ->label('Skor CBT')
                    ->sortable()
                    ->placeholder('-')
                    ->suffix('/100')
                    ->toggleable(),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label('Status')
                    ->options([
                        'pending' => 'Menunggu',
                        'paid' => 'Lunas',
                        'cancelled' => 'Dibatalkan',
                    ]),
            ])
            ->actions([
                Actions\ViewAction::make(),
                Actions\DeleteAction::make(),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListRegistrations::route('/'),
            'view' => Pages\ViewRegistration::route('/{record}'),
        ];
    }

    public static function canCreate(): bool
    {
        return false;
    }
}
