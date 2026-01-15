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

// About page
Route::get('/tentang', [HomeController::class, 'about'])->name('about');

// Registration routes (Legacy - single step)
// Route::prefix('registration')->name('registration.')->group(function () {
//     Route::get('/create', [RegistrationController::class, 'create'])->name('create');
//     Route::post('/store', [RegistrationController::class, 'store'])->name('store');
//     Route::get('/{registration}/payment', [RegistrationController::class, 'payment'])->name('payment');
//     Route::get('/{registration}/complete', [RegistrationController::class, 'complete'])->name('complete');
// });

// Multi-Step Registration routes (4-step flow) - Main registration flow
Route::prefix('pendaftaran')->name('registration.')->group(function () {
    // Step 1: Search and select path (no middleware needed)
    Route::get('/', [App\Http\Controllers\MultiStepRegistrationController::class, 'searchPaths'])->name('search');
    Route::get('/jalur/{path:slug}', [App\Http\Controllers\MultiStepRegistrationController::class, 'showPathDetail'])->name('path.detail');
    Route::post('/jalur/{path}/pilih', [App\Http\Controllers\MultiStepRegistrationController::class, 'selectPath'])->name('path.select');
    
    // Step 2: Registration form (requires path selection)
    Route::middleware('registration.step:form')->group(function () {
        Route::get('/formulir', [App\Http\Controllers\MultiStepRegistrationController::class, 'showForm'])->name('form');
        Route::post('/formulir', [App\Http\Controllers\MultiStepRegistrationController::class, 'storeForm'])->name('form.store');
        Route::get('/pindah-jalur', [App\Http\Controllers\MultiStepRegistrationController::class, 'changePath'])->name('change-path');
        Route::get('/programs/{type}', [App\Http\Controllers\MultiStepRegistrationController::class, 'getProgramsByType'])->name('programs.by-type');
    });
    
    // Step 3: Confirmation/Review (requires form completion)
    Route::middleware('registration.step:confirmation')->group(function () {
        Route::get('/konfirmasi', [App\Http\Controllers\MultiStepRegistrationController::class, 'showConfirmation'])->name('confirmation');
        Route::get('/edit', [App\Http\Controllers\MultiStepRegistrationController::class, 'editForm'])->name('edit');
        Route::post('/konfirmasi', [App\Http\Controllers\MultiStepRegistrationController::class, 'confirmData'])->name('confirm');
    });
    
    // Step 4: Payment (requires data confirmation)
    Route::middleware('registration.step:payment')->group(function () {
        Route::get('/pembayaran', [App\Http\Controllers\MultiStepRegistrationController::class, 'showPayment'])->name('payment');
        Route::post('/voucher', [App\Http\Controllers\MultiStepRegistrationController::class, 'applyVoucher'])->name('voucher.apply');
        Route::post('/pembayaran', [App\Http\Controllers\MultiStepRegistrationController::class, 'processPayment'])->name('payment.process');
    });
    
    // Success (no middleware - accessed after registration complete)
    Route::get('/sukses/{registration}', [App\Http\Controllers\MultiStepRegistrationController::class, 'showSuccess'])->name('success');
    
    // Utilities
    Route::get('/restart', [App\Http\Controllers\MultiStepRegistrationController::class, 'restart'])->name('restart');
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
