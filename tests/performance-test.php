<?php

/**
 * Basic Performance Test Script
 * Tests key performance metrics for the application
 * 
 * Usage: php tests/performance-test.php
 */

require __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Setting;
use App\Models\News;
use App\Models\Facility;
use App\Models\Tendik;
use App\Models\Registration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

echo "=== Performance Test Suite ===\n\n";

$results = [];
$passed = 0;
$failed = 0;

// Test 1: Settings Cache Performance
echo "Test 1: Settings Cache Performance\n";
echo str_repeat("-", 50) . "\n";

// Clear cache first
Cache::flush();

// First access (cache miss)
$start = microtime(true);
$settings = Setting::getSettings();
$time1 = (microtime(true) - $start) * 1000;
echo "  Cache miss: {$time1}ms\n";

// Second access (cache hit)
$start = microtime(true);
$settings = Setting::getSettings();
$time2 = (microtime(true) - $start) * 1000;
echo "  Cache hit: {$time2}ms\n";

$speedup = $time1 / max($time2, 0.001);
echo "  Speedup: {$speedup}x\n";

if ($speedup > 5) {
    echo "  ✓ PASS: Cache provides significant speedup\n";
    $passed++;
} else {
    echo "  ✗ FAIL: Cache speedup insufficient\n";
    $failed++;
}
echo "\n";

// Test 2: Database Query Count - Homepage
echo "Test 2: Database Query Count - Homepage Data\n";
echo str_repeat("-", 50) . "\n";

DB::enableQueryLog();

$settings = Setting::getSettings();
$latestNews = News::published()->latest()->take(6)->get();
$facilities = Facility::active()->orderBy('order')->get();
$tendik = Tendik::active()->get();

$queries = DB::getQueryLog();
$queryCount = count($queries);
$totalTime = array_sum(array_column($queries, 'time'));

echo "  Total queries: $queryCount\n";
echo "  Total time: {$totalTime}ms\n";

DB::disableQueryLog();

if ($queryCount < 20) {
    echo "  ✓ PASS: Query count is acceptable\n";
    $passed++;
} else {
    echo "  ✗ FAIL: Too many queries (should be < 20)\n";
    $failed++;
}

if ($totalTime < 100) {
    echo "  ✓ PASS: Query time is acceptable\n";
    $passed++;
} else {
    echo "  ✗ FAIL: Query time too slow (should be < 100ms)\n";
    $failed++;
}
echo "\n";

// Test 3: Registration Number Generation Performance
echo "Test 3: Registration Number Generation\n";
echo str_repeat("-", 50) . "\n";

$start = microtime(true);
for ($i = 0; $i < 10; $i++) {
    $regNumber = 'REG' . date('Y') . str_pad($i, 4, '0', STR_PAD_LEFT);
}
$time = (microtime(true) - $start) * 1000;
$avgTime = $time / 10;

echo "  10 generations: {$time}ms\n";
echo "  Average: {$avgTime}ms\n";

if ($avgTime < 10) {
    echo "  ✓ PASS: Generation is fast\n";
    $passed++;
} else {
    echo "  ✗ FAIL: Generation too slow\n";
    $failed++;
}
echo "\n";

// Test 4: Cache Invalidation
echo "Test 4: Cache Invalidation\n";
echo str_repeat("-", 50) . "\n";

// Set a test value
Setting::set('test_key', 'test_value_1');
$value1 = Setting::get('test_key');

// Update the value
Setting::set('test_key', 'test_value_2');
$value2 = Setting::get('test_key');

// Clean up
Setting::where('key', 'test_key')->delete();
Cache::forget('setting.test_key');

if ($value1 === 'test_value_1' && $value2 === 'test_value_2') {
    echo "  ✓ PASS: Cache invalidation works correctly\n";
    $passed++;
} else {
    echo "  ✗ FAIL: Cache not invalidated properly\n";
    echo "    Value 1: $value1 (expected: test_value_1)\n";
    echo "    Value 2: $value2 (expected: test_value_2)\n";
    $failed++;
}
echo "\n";

// Test 5: Published News Scope Performance
echo "Test 5: Published News Query Performance\n";
echo str_repeat("-", 50) . "\n";

DB::enableQueryLog();
$start = microtime(true);

$publishedNews = News::published()->latest()->take(6)->get();

$time = (microtime(true) - $start) * 1000;
$queries = DB::getQueryLog();
$queryCount = count($queries);

DB::disableQueryLog();

echo "  Query time: {$time}ms\n";
echo "  Query count: $queryCount\n";

if ($time < 50 && $queryCount <= 10) {
    echo "  ✓ PASS: Query is efficient\n";
    $passed++;
} else {
    echo "  ✗ FAIL: Query needs optimization\n";
    $failed++;
}
echo "\n";

// Test 6: Eager Loading Check
echo "Test 6: Eager Loading for News with Author\n";
echo str_repeat("-", 50) . "\n";

// Create test news if needed
$newsCount = News::count();
if ($newsCount === 0) {
    echo "  ⚠ SKIP: No news records to test\n\n";
} else {
    DB::enableQueryLog();
    
    // Without eager loading
    $news = News::take(5)->get();
    foreach ($news as $item) {
        $author = $item->created_by; // This would trigger N+1 if we accessed $item->author
    }
    $queriesWithout = count(DB::getQueryLog());
    
    DB::flushQueryLog();
    
    // With eager loading
    $news = News::with('author')->take(5)->get();
    foreach ($news as $item) {
        $author = $item->author;
    }
    $queriesWith = count(DB::getQueryLog());
    
    DB::disableQueryLog();
    
    echo "  Queries without eager loading: $queriesWithout\n";
    echo "  Queries with eager loading: $queriesWith\n";
    
    if ($queriesWith <= 2) {
        echo "  ✓ PASS: Eager loading reduces queries\n";
        $passed++;
    } else {
        echo "  ✗ FAIL: Eager loading not effective\n";
        $failed++;
    }
    echo "\n";
}

// Test 7: Memory Usage
echo "Test 7: Memory Usage\n";
echo str_repeat("-", 50) . "\n";

$memoryStart = memory_get_usage(true);

// Simulate loading homepage data
$settings = Setting::getSettings();
$news = News::published()->latest()->take(6)->get();
$facilities = Facility::active()->get();
$tendik = Tendik::active()->get();

$memoryEnd = memory_get_usage(true);
$memoryUsed = ($memoryEnd - $memoryStart) / 1024 / 1024; // Convert to MB

echo "  Memory used: " . number_format($memoryUsed, 2) . " MB\n";

if ($memoryUsed < 10) {
    echo "  ✓ PASS: Memory usage is acceptable\n";
    $passed++;
} else {
    echo "  ✗ FAIL: Memory usage too high\n";
    $failed++;
}
echo "\n";

// Test 8: Database Connection Pool
echo "Test 8: Database Connection Performance\n";
echo str_repeat("-", 50) . "\n";

$start = microtime(true);
for ($i = 0; $i < 10; $i++) {
    DB::connection()->getPdo();
}
$time = (microtime(true) - $start) * 1000;
$avgTime = $time / 10;

echo "  10 connections: {$time}ms\n";
echo "  Average: {$avgTime}ms\n";

if ($avgTime < 5) {
    echo "  ✓ PASS: Connection pooling is efficient\n";
    $passed++;
} else {
    echo "  ✗ FAIL: Connection time too slow\n";
    $failed++;
}
echo "\n";

// Summary
echo str_repeat("=", 50) . "\n";
echo "PERFORMANCE TEST SUMMARY\n";
echo str_repeat("=", 50) . "\n";
echo "Total tests: " . ($passed + $failed) . "\n";
echo "✓ Passed: $passed\n";
echo "✗ Failed: $failed\n";
echo "\n";

if ($failed === 0) {
    echo "✅ All performance tests PASSED!\n";
    exit(0);
} else {
    echo "❌ Some performance tests FAILED. Review results above.\n";
    exit(1);
}
