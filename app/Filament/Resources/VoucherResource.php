<?php

namespace App\Filament\Resources;

use App\Filament\Resources\VoucherResource\Pages;
use App\Models\Voucher;
use App\Models\RegistrationPath;
use BackedEnum;
use Filament\Actions;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
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

class VoucherResource extends Resource
{
    protected static ?string $model = Voucher::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedTicket;

    protected static ?string $navigationLabel = 'Voucher';

    protected static ?string $modelLabel = 'Voucher';

    protected static ?string $pluralModelLabel = 'Voucher';

    protected static UnitEnum|string|null $navigationGroup = 'Pendaftaran';

    protected static ?int $navigationSort = 4;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('code')
                    ->label('Kode Voucher')
                    ->required()
                    ->maxLength(50)
                    ->unique(ignoreRecord: true)
                    ->helperText('Kode unik untuk voucher (contoh: DISKON50)'),

                Select::make('type')
                    ->label('Tipe Diskon')
                    ->options([
                        'percentage' => 'Persentase (%)',
                        'fixed' => 'Nominal Tetap (Rp)',
                    ])
                    ->required()
                    ->live(),

                TextInput::make('value')
                    ->label('Nilai Diskon')
                    ->required()
                    ->numeric()
                    ->prefix(fn ($get) => $get('type') === 'fixed' ? 'Rp' : '')
                    ->suffix(fn ($get) => $get('type') === 'percentage' ? '%' : '')
                    ->helperText(fn ($get) => $get('type') === 'percentage' 
                        ? 'Masukkan angka 1-100 untuk persentase' 
                        : 'Masukkan nominal diskon dalam rupiah'),

                TextInput::make('max_uses')
                    ->label('Maksimal Penggunaan')
                    ->numeric()
                    ->helperText('Kosongkan untuk penggunaan tidak terbatas'),

                TextInput::make('used_count')
                    ->label('Sudah Digunakan')
                    ->numeric()
                    ->default(0)
                    ->disabled()
                    ->dehydrated(false),

                DateTimePicker::make('valid_from')
                    ->label('Berlaku Dari')
                    ->required()
                    ->native(false),

                DateTimePicker::make('valid_until')
                    ->label('Berlaku Sampai')
                    ->required()
                    ->native(false)
                    ->after('valid_from'),

                Select::make('applicable_paths')
                    ->label('Berlaku Untuk Jalur')
                    ->multiple()
                    ->options(RegistrationPath::pluck('name', 'id'))
                    ->helperText('Kosongkan untuk berlaku di semua jalur pendaftaran'),

                Toggle::make('is_active')
                    ->label('Aktif')
                    ->default(true)
                    ->helperText('Voucher hanya bisa digunakan jika aktif'),
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
                    ->weight('bold')
                    ->copyable()
                    ->copyMessage('Kode voucher disalin!'),

                TextColumn::make('type')
                    ->label('Tipe')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'percentage' => 'success',
                        'fixed' => 'info',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'percentage' => 'Persentase',
                        'fixed' => 'Nominal',
                        default => $state,
                    }),

                TextColumn::make('value')
                    ->label('Nilai')
                    ->formatStateUsing(function ($record) {
                        if ($record->type === 'percentage') {
                            return $record->value . '%';
                        }
                        return 'Rp ' . number_format($record->value, 0, ',', '.');
                    })
                    ->sortable(),

                TextColumn::make('usage')
                    ->label('Penggunaan')
                    ->formatStateUsing(function ($record) {
                        $used = $record->used_count;
                        $max = $record->max_uses ?? '∞';
                        $percentage = $record->max_uses ? round(($used / $record->max_uses) * 100) : 0;
                        return "{$used} / {$max} ({$percentage}%)";
                    })
                    ->color(function ($record) {
                        if (!$record->max_uses) return 'success';
                        $percentage = ($record->used_count / $record->max_uses) * 100;
                        if ($percentage >= 90) return 'danger';
                        if ($percentage >= 70) return 'warning';
                        return 'success';
                    }),

                TextColumn::make('valid_from')
                    ->label('Berlaku Dari')
                    ->dateTime('d M Y')
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('valid_until')
                    ->label('Sampai')
                    ->dateTime('d M Y')
                    ->sortable()
                    ->toggleable(),

                IconColumn::make('is_active')
                    ->label('Status')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('danger'),
            ])
            ->filters([
                SelectFilter::make('type')
                    ->label('Tipe')
                    ->options([
                        'percentage' => 'Persentase',
                        'fixed' => 'Nominal',
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
            'index' => Pages\ListVouchers::route('/'),
            'create' => Pages\CreateVoucher::route('/create'),
            'edit' => Pages\EditVoucher::route('/{record}/edit'),
            'view' => Pages\ViewVoucher::route('/{record}'),
        ];
    }
}
