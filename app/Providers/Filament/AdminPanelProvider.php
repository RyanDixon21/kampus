<?php

namespace App\Providers\Filament;

use App\Models\Setting;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets\AccountWidget;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        // Get settings for branding - with comprehensive error handling
        $universityShortName = 'STT Pratama Adi';
        $logoUrl = asset('logo.png');
        
        try {
            // Only try to get settings if the table exists
            if (\Schema::hasTable('settings')) {
                $settings = Setting::getSettings();
                $universityShortName = $settings['university_short_name'] ?? 'STT Pratama Adi';
                
                // Handle logo with proper checks
                if (isset($settings['logo']) && $settings['logo']) {
                    try {
                        if (Storage::disk('public')->exists($settings['logo'])) {
                            $logoUrl = Storage::url($settings['logo']);
                        }
                    } catch (\Exception $e) {
                        // Fallback to default logo if storage fails
                        \Log::warning('Failed to load logo from storage: ' . $e->getMessage());
                    }
                }
            }
        } catch (\Exception $e) {
            // Log error but don't break Filament
            \Log::warning('Failed to load settings in Filament: ' . $e->getMessage());
        }

        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->login()
            ->brandName($universityShortName)
            ->brandLogo($logoUrl)
            ->brandLogoHeight('2.5rem')
            ->sidebarCollapsibleOnDesktop()
            ->favicon($logoUrl)
            ->globalSearch(false)
            ->colors([
                'primary' => Color::Sky,
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\Filament\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\Filament\Pages')
            ->pages([
                // Dashboard hidden
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\Filament\Widgets')
            ->widgets([
                AccountWidget::class,
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ]);
    }
}
