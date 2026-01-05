<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\CBTController;

// Home page
Route::get('/', [HomeController::class, 'index'])->name('home');

// News routes
Route::get('/news', [HomeController::class, 'allNews'])->name('news.index');
Route::get('/news/{news:slug}', [HomeController::class, 'showNews'])->name('news.show');

// Facility detail route
Route::get('/facility/{facility:slug}', [HomeController::class, 'showFacility'])->name('facility.show');

// Registration routes
Route::prefix('registration')->name('registration.')->group(function () {
    Route::get('/create', [RegistrationController::class, 'create'])->name('create');
    Route::post('/store', [RegistrationController::class, 'store'])->name('store');
    Route::get('/{registration}/payment', [RegistrationController::class, 'payment'])->name('payment');
    Route::get('/{registration}/complete', [RegistrationController::class, 'complete'])->name('complete');
});

// CBT routes
Route::prefix('cbt')->name('cbt.')->group(function () {
    Route::get('/login', [CBTController::class, 'login'])->name('login');
    Route::post('/authenticate', [CBTController::class, 'authenticate'])->name('authenticate');
    Route::get('/start', [CBTController::class, 'start'])->name('start');
    Route::post('/submit', [CBTController::class, 'submit'])->name('submit');
});

// Debug route
Route::get('/debug-hero', function () {
    $heroes = App\Models\HeroCard::all();
    
    echo "<h1>Hero Cards Debug</h1>";
    echo "<p>Total: " . $heroes->count() . "</p>";
    
    foreach ($heroes as $hero) {
        echo "<hr>";
        echo "<h3>ID: {$hero->id}</h3>";
        echo "<p>Title: {$hero->title}</p>";
        echo "<p>Subtitle: {$hero->subtitle}</p>";
        echo "<p>Background Image: " . ($hero->background_image ?? 'NULL') . "</p>";
        
        if ($hero->background_image) {
            $exists = Storage::disk('public')->exists($hero->background_image);
            echo "<p>File exists: " . ($exists ? 'YES' : 'NO') . "</p>";
            
            if ($exists) {
                $url = Storage::url($hero->background_image);
                echo "<p>URL: {$url}</p>";
                echo "<img src='{$url}' style='max-width: 300px;'>";
            }
        }
    }
});

// Debug news route
Route::get('/debug-news', function () {
    $news = App\Models\News::all();
    
    echo "<h1>News Debug</h1>";
    echo "<p>Total: " . $news->count() . "</p>";
    
    foreach ($news as $item) {
        echo "<hr>";
        echo "<h3>ID: {$item->id}</h3>";
        echo "<p>Title: {$item->title}</p>";
        echo "<p>Slug: {$item->slug}</p>";
        echo "<p>Thumbnail: " . ($item->thumbnail ?? 'NULL') . "</p>";
        echo "<p>Status: {$item->status}</p>";
        
        if ($item->thumbnail) {
            $exists = Storage::disk('public')->exists($item->thumbnail);
            echo "<p>File exists: " . ($exists ? 'YES' : 'NO') . "</p>";
            
            if ($exists) {
                $url = Storage::url($item->thumbnail);
                echo "<p>URL: {$url}</p>";
                echo "<img src='{$url}' style='max-width: 300px;'>";
            } else {
                echo "<p style='color: red;'>File not found in storage!</p>";
                echo "<p>Looking for: storage/app/public/{$item->thumbnail}</p>";
            }
        }
    }
});
