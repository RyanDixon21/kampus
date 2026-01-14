<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RegistrationResource\Pages;
use App\Models\Registration;
use BackedEnum;
use Filament\Actions;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use UnitEnum;

class RegistrationResource extends Resource
{
    protected static ?string $model = Registration::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedClipboardDocumentList;

    protected static ?string $navigationLabel = 'Data Pendaftaran';

    protected static ?string $modelLabel = 'Pendaftaran';

    protected static ?string $pluralModelLabel = 'Pendaftaran';

    protected static UnitEnum|string|null $navigationGroup = 'Pendaftaran';

    protected static ?int $navigationSort = 1;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Jalur & Program Studi')
                    ->schema([
                        Placeholder::make('registrationPath.name')
                            ->label('Jalur Pendaftaran')
                            ->content(fn (?Registration $record): string => $record?->registrationPath?->name ?? '-'),

                        Placeholder::make('firstChoiceProgram.name')
                            ->label('Program Studi Pilihan 1')
                            ->content(fn (?Registration $record): string => $record?->firstChoiceProgram?->name ?? '-'),

                        Placeholder::make('secondChoiceProgram.name')
                            ->label('Program Studi Pilihan 2')
                            ->content(fn (?Registration $record): string => $record?->secondChoiceProgram?->name ?? '-'),
                    ])
                    ->columns(3),

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

                        Placeholder::make('date_of_birth')
                            ->label('Tanggal Lahir')
                            ->content(fn (?Registration $record): string => 
                                $record?->date_of_birth 
                                    ? $record->date_of_birth->format('d M Y') 
                                    : '-'
                            ),

                        Placeholder::make('address')
                            ->label('Alamat')
                            ->content(fn (?Registration $record): string => $record?->address ?? '-')
                            ->columnSpanFull(),
                    ])
                    ->columns(2),

                Section::make('Pembayaran')
                    ->schema([
                        Placeholder::make('payment_method')
                            ->label('Metode Pembayaran')
                            ->content(fn (?Registration $record): string => $record?->payment_method ?? '-'),

                        Placeholder::make('payment_amount')
                            ->label('Biaya Pendaftaran')
                            ->content(fn (?Registration $record): string => 
                                $record?->payment_amount 
                                    ? 'Rp ' . number_format($record->payment_amount, 0, ',', '.') 
                                    : '-'
                            ),

                        Placeholder::make('discount_amount')
                            ->label('Diskon')
                            ->content(fn (?Registration $record): string => 
                                $record?->discount_amount 
                                    ? 'Rp ' . number_format($record->discount_amount, 0, ',', '.') 
                                    : '-'
                            ),

                        Placeholder::make('final_amount')
                            ->label('Total Bayar')
                            ->content(fn (?Registration $record): string => 
                                $record?->final_amount 
                                    ? 'Rp ' . number_format($record->final_amount, 0, ',', '.') 
                                    : '-'
                            ),

                        Placeholder::make('voucher_code')
                            ->label('Kode Voucher')
                            ->content(fn (?Registration $record): string => $record?->voucher_code ?? '-'),

                        Placeholder::make('referral_code')
                            ->label('Kode Referral')
                            ->content(fn (?Registration $record): string => $record?->referral_code ?? '-'),
                    ])
                    ->columns(3),

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
                                'unpaid' => '⚪ Belum Bayar',
                                'failed' => '🔴 Gagal',
                                default => '-',
                            }),

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

                TextColumn::make('registrationPath.name')
                    ->label('Jalur')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('name')
                    ->label('Nama')
                    ->searchable()
                    ->sortable()
                    ->limit(50),

                TextColumn::make('firstChoiceProgram.name')
                    ->label('Prodi Pilihan 1')
                    ->searchable()
                    ->sortable()
                    ->limit(40)
                    ->toggleable(),

                TextColumn::make('secondChoiceProgram.name')
                    ->label('Prodi Pilihan 2')
                    ->searchable()
                    ->sortable()
                    ->limit(40)
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('program_type')
                    ->label('Tipe')
                    ->badge()
                    ->color(fn (?string $state): string => match ($state) {
                        'IPA' => 'success',
                        'IPS' => 'info',
                        default => 'gray',
                    })
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('email')
                    ->label('Email')
                    ->searchable()
                    ->sortable()
                    ->limit(50)
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('payment_method')
                    ->label('Metode Bayar')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('final_amount')
                    ->label('Total Bayar')
                    ->money('IDR')
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('voucher_code')
                    ->label('Voucher')
                    ->searchable()
                    ->placeholder('-')
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('data_confirmed_at')
                    ->label('Konfirmasi Data')
                    ->dateTime('d M Y, H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

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

                TextColumn::make('payment_status')
                    ->label('Status Bayar')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'paid' => 'success',
                        'pending' => 'warning',
                        'unpaid' => 'gray',
                        'failed' => 'danger',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'paid' => 'Lunas',
                        'pending' => 'Menunggu',
                        'unpaid' => 'Belum Bayar',
                        'failed' => 'Gagal',
                        default => $state,
                    })
                    ->toggleable(),

                TextColumn::make('created_at')
                    ->label('Tanggal Daftar')
                    ->dateTime('d M Y, H:i')
                    ->sortable(),

                TextColumn::make('cbt_score')
                    ->label('Skor CBT')
                    ->sortable()
                    ->placeholder('-')
                    ->suffix('/100')
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('phone')
                    ->label('Telepon')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('registration_path_id')
                    ->label('Jalur Pendaftaran')
                    ->relationship('registrationPath', 'name'),

                SelectFilter::make('first_choice_program_id')
                    ->label('Program Studi')
                    ->relationship('firstChoiceProgram', 'name'),

                SelectFilter::make('program_type')
                    ->label('Tipe Program')
                    ->options([
                        'IPA' => 'IPA',
                        'IPS' => 'IPS',
                    ]),

                SelectFilter::make('payment_method')
                    ->label('Metode Pembayaran')
                    ->options([
                        'tokopedia' => 'Tokopedia',
                        'mandiri' => 'Bank Mandiri',
                        'shopee' => 'Shopee',
                        'bjb' => 'Bank BJB',
                    ]),

                SelectFilter::make('status')
                    ->label('Status')
                    ->options([
                        'pending' => 'Menunggu',
                        'paid' => 'Lunas',
                        'cancelled' => 'Dibatalkan',
                    ]),
                
                SelectFilter::make('payment_status')
                    ->label('Status Pembayaran')
                    ->options([
                        'paid' => 'Lunas',
                        'pending' => 'Menunggu',
                        'unpaid' => 'Belum Bayar',
                        'failed' => 'Gagal',
                    ]),
            ])
            ->actions([
                Actions\ViewAction::make(),
                Actions\EditAction::make()
                    ->modalHeading('Update Status Pendaftaran')
                    ->form([
                        Select::make('status')
                            ->label('Status Pendaftaran')
                            ->options([
                                'pending' => 'Menunggu',
                                'paid' => 'Lunas',
                                'cancelled' => 'Dibatalkan',
                            ])
                            ->required(),
                        
                        Select::make('payment_status')
                            ->label('Status Pembayaran')
                            ->options([
                                'paid' => 'Lunas',
                                'pending' => 'Menunggu',
                                'unpaid' => 'Belum Bayar',
                                'failed' => 'Gagal',
                            ])
                            ->required(),
                        
                        TextInput::make('payment_amount')
                            ->label('Jumlah Pembayaran')
                            ->numeric()
                            ->prefix('Rp'),
                        
                        TextInput::make('cbt_score')
                            ->label('Skor CBT')
                            ->numeric()
                            ->minValue(0)
                            ->maxValue(100)
                            ->suffix('/100'),
                    ]),
                Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Actions\DeleteBulkAction::make(),
                Actions\ExportBulkAction::make()
                    ->label('Export ke Excel'),
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

    public static function getWidgets(): array
    {
        return [
            RegistrationResource\Widgets\RegistrationStatsWidget::class,
        ];
    }

    public static function canCreate(): bool
    {
        return false;
    }
}
