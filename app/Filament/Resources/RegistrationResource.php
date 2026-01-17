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
                Section::make()
                    ->schema([
                        Placeholder::make('registration_number')
                            ->label('Nomor Pendaftaran')
                            ->content(fn (?Registration $record): string => $record?->registration_number ?? '-')
                            ->extraAttributes(['class' => 'text-2xl font-bold text-blue-600']),
                        
                        Placeholder::make('payment_status')
                            ->label('Status Pembayaran')
                            ->content(fn (?Registration $record): string => match ($record?->payment_status) {
                                'paid' => '✅ Lunas',
                                'pending' => '⏳ Menunggu Verifikasi',
                                'unpaid' => '❌ Belum Bayar',
                                'failed' => '⛔ Gagal',
                                default => '-',
                            }),
                        
                        Placeholder::make('created_at')
                            ->label('Tanggal Pendaftaran')
                            ->content(fn (?Registration $record): string => 
                                $record?->created_at 
                                    ? $record->created_at->format('d F Y, H:i') . ' WIB'
                                    : '-'
                            ),
                    ])
                    ->columns(3)
                    ->columnSpanFull(),

                Section::make('Jalur & Program Studi')
                    ->schema([
                        Placeholder::make('registrationPath.name')
                            ->label('Jalur Pendaftaran')
                            ->content(fn (?Registration $record): string => $record?->registrationPath?->name ?? '-'),

                        Placeholder::make('program_type')
                            ->label('Jenis Program')
                            ->content(fn (?Registration $record): string => $record?->program_type ?? '-'),

                        Placeholder::make('firstChoiceProgram.name')
                            ->label('Program Studi Pilihan 1')
                            ->content(fn (?Registration $record): string => 
                                $record?->firstChoiceProgram 
                                    ? $record->firstChoiceProgram->degree_level . ' - ' . $record->firstChoiceProgram->name
                                    : '-'
                            ),

                        Placeholder::make('secondChoiceProgram.name')
                            ->label('Program Studi Pilihan 2')
                            ->content(fn (?Registration $record): string => 
                                $record?->secondChoiceProgram 
                                    ? $record->secondChoiceProgram->degree_level . ' - ' . $record->secondChoiceProgram->name
                                    : '-'
                            ),
                    ])
                    ->columns(2)
                    ->collapsible(),

                Section::make('Data Pribadi')
                    ->schema([
                        Placeholder::make('name')
                            ->label('Nama Lengkap')
                            ->content(fn (?Registration $record): string => $record?->name ?? '-'),

                        Placeholder::make('email')
                            ->label('Email')
                            ->content(fn (?Registration $record): string => $record?->email ?? '-'),

                        Placeholder::make('phone')
                            ->label('No. Telepon')
                            ->content(fn (?Registration $record): string => $record?->phone ?? '-'),

                        Placeholder::make('date_of_birth')
                            ->label('Tanggal Lahir')
                            ->content(fn (?Registration $record): string => 
                                $record?->date_of_birth 
                                    ? $record->date_of_birth->format('d F Y') 
                                    : '-'
                            ),

                        Placeholder::make('address')
                            ->label('Alamat Lengkap')
                            ->content(fn (?Registration $record): string => $record?->address ?? '-')
                            ->columnSpanFull(),
                    ])
                    ->columns(2)
                    ->collapsible(),

                Section::make('Pembayaran')
                    ->schema([
                        Placeholder::make('payment_method')
                            ->label('Metode Pembayaran')
                            ->content(fn (?Registration $record): string => ucwords(str_replace('_', ' ', $record?->payment_method ?? '-'))),

                        Placeholder::make('payment_date')
                            ->label('Tanggal Pembayaran')
                            ->content(fn (?Registration $record): string => 
                                $record?->payment_date 
                                    ? $record->payment_date->format('d F Y, H:i') . ' WIB'
                                    : 'Belum dibayar'
                            ),

                        Placeholder::make('payment_amount')
                            ->label('Biaya Pendaftaran')
                            ->content(fn (?Registration $record): string => 
                                $record?->payment_amount 
                                    ? 'Rp ' . number_format($record->payment_amount, 0, ',', '.') 
                                    : 'Rp 0'
                            ),

                        Placeholder::make('discount_amount')
                            ->label('Potongan Diskon')
                            ->content(fn (?Registration $record): string => 
                                $record?->discount_amount && $record->discount_amount > 0
                                    ? 'Rp ' . number_format($record->discount_amount, 0, ',', '.') 
                                    : 'Rp 0'
                            ),

                        Placeholder::make('final_amount')
                            ->label('Total Pembayaran')
                            ->content(fn (?Registration $record): string => 
                                $record?->final_amount 
                                    ? 'Rp ' . number_format($record->final_amount, 0, ',', '.') 
                                    : 'Rp 0'
                            )
                            ->extraAttributes(['class' => 'text-xl font-bold text-green-600']),

                        Placeholder::make('voucher_code')
                            ->label('Kode Voucher')
                            ->content(fn (?Registration $record): string => $record?->voucher_code ?? 'Tidak menggunakan voucher'),

                        Placeholder::make('referral_code')
                            ->label('Kode Referral')
                            ->content(fn (?Registration $record): string => $record?->referral_code ?? 'Tidak ada referral'),
                    ])
                    ->columns(3)
                    ->collapsible(),

                Section::make('Tes CBT')
                    ->schema([
                        Placeholder::make('cbt_score')
                            ->label('Nilai CBT')
                            ->content(fn (?Registration $record): string => 
                                $record?->cbt_score !== null 
                                    ? $record->cbt_score . ' / 100' 
                                    : 'Belum mengikuti CBT'
                            )
                            ->extraAttributes(['class' => 'text-lg font-semibold']),

                        Placeholder::make('cbt_completed_at')
                            ->label('Waktu Selesai CBT')
                            ->content(fn (?Registration $record): string => 
                                $record?->cbt_completed_at 
                                    ? $record->cbt_completed_at->format('d F Y, H:i') . ' WIB'
                                    : 'Belum mengikuti CBT'
                            ),
                    ])
                    ->columns(2)
                    ->collapsible()
                    ->collapsed(),
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
                    ->sortable(),

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
                        Select::make('payment_status')
                            ->label('Status Pembayaran')
                            ->options([
                                'paid' => 'Lunas',
                                'pending' => 'Menunggu',
                                'unpaid' => 'Belum Bayar',
                                'failed' => 'Gagal',
                            ])
                            ->required()
                            ->reactive()
                            ->afterStateUpdated(function ($state, callable $set) {
                                if ($state === 'paid') {
                                    $set('status', 'paid');
                                    $set('payment_date', now());
                                }
                            }),
                        
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
                    ])
                    ->mutateFormDataUsing(function (array $data): array {
                        // Auto update status to paid if payment_status is paid
                        if (isset($data['payment_status']) && $data['payment_status'] === 'paid') {
                            $data['status'] = 'paid';
                            if (!isset($data['payment_date'])) {
                                $data['payment_date'] = now();
                            }
                        }
                        return $data;
                    }),
                Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Actions\DeleteBulkAction::make(),
                Actions\BulkAction::make('mark_as_paid')
                    ->label('Tandai Lunas')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->requiresConfirmation()
                    ->modalHeading('Tandai Sebagai Lunas')
                    ->modalDescription('Apakah Anda yakin ingin menandai pendaftaran yang dipilih sebagai lunas?')
                    ->action(function ($records) {
                        $records->each(function ($record) {
                            $record->update([
                                'payment_status' => 'paid',
                                'status' => 'paid',
                                'payment_date' => $record->payment_date ?? now(),
                            ]);
                        });
                    })
                    ->deselectRecordsAfterCompletion()
                    ->successNotificationTitle('Status pembayaran berhasil diupdate'),
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
