<?php

namespace App\Filament\Resources\RegistrationResource\Widgets;

use App\Models\Registration;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class RegistrationStatsWidget extends BaseWidget
{
    protected function getStats(): array
    {
        $total = Registration::count();
        $pending = Registration::where('status', 'pending')->count();
        $paid = Registration::where('status', 'paid')->count();
        $cancelled = Registration::where('status', 'cancelled')->count();
        $paidPayment = Registration::where('payment_status', 'paid')->count();
        $avgCbtScore = Registration::whereNotNull('cbt_score')->avg('cbt_score');

        return [
            Stat::make('Total Pendaftaran', $total)
                ->description('Total semua pendaftaran')
                ->descriptionIcon('heroicon-o-users')
                ->color('primary'),

            Stat::make('Menunggu', $pending)
                ->description('Pendaftaran menunggu')
                ->descriptionIcon('heroicon-o-clock')
                ->color('warning'),

            Stat::make('Lunas', $paid)
                ->description('Pendaftaran lunas')
                ->descriptionIcon('heroicon-o-check-circle')
                ->color('success'),

            Stat::make('Pembayaran Lunas', $paidPayment)
                ->description('Sudah membayar')
                ->descriptionIcon('heroicon-o-banknotes')
                ->color('success'),

            Stat::make('Rata-rata Skor CBT', $avgCbtScore ? number_format($avgCbtScore, 1) : '-')
                ->description('Dari semua peserta')
                ->descriptionIcon('heroicon-o-academic-cap')
                ->color('info'),

            Stat::make('Dibatalkan', $cancelled)
                ->description('Pendaftaran dibatalkan')
                ->descriptionIcon('heroicon-o-x-circle')
                ->color('danger'),
        ];
    }
}
