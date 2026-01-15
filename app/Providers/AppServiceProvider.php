<?php

namespace App\Providers;

use App\Models\Facility;
use App\Models\HeroCard;
use App\Models\News;
use App\Models\Setting;
use App\Models\Tendik;
use App\Observers\FacilityObserver;
use App\Observers\HeroCardObserver;
use App\Observers\NewsObserver;
use App\Observers\SettingObserver;
use App\Observers\TendikObserver;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Register observers to handle file deletion
        Setting::observe(SettingObserver::class);
        Tendik::observe(TendikObserver::class);
        HeroCard::observe(HeroCardObserver::class);
        Facility::observe(FacilityObserver::class);
        News::observe(NewsObserver::class);

        // Share settings to all views
        View::composer('*', function ($view) {
            // Only load if settings table exists and settings not already set
            if (!isset($view->getData()['settings'])) {
                try {
                    if (Schema::hasTable('settings')) {
                        $settings = Setting::getSettings();
                        $view->with('settings', $settings);
                    } else {
                        $view->with('settings', []);
                    }
                } catch (\Exception $e) {
                    $view->with('settings', []);
                }
            }
        });
    }
}
