<?php

/**
 * Setup Verification Script
 * Run this script to verify the application is properly configured for testing
 * 
 * Usage: php tests/verify-setup.php
 */

echo "=== STT Pratama Adi Website - Setup Verification ===\n\n";

$checks = [];
$warnings = [];
$errors = [];

// Check 1: PHP Version
echo "Checking PHP version... ";
$phpVersion = PHP_VERSION;
if (version_compare($phpVersion, '8.2.0', '>=')) {
    echo "✓ PHP $phpVersion\n";
    $checks[] = "PHP version: $phpVersion";
} else {
    echo "✗ PHP $phpVersion (requires 8.2+)\n";
    $errors[] = "PHP version too old: $phpVersion";
}

// Check 2: Required PHP Extensions
echo "\nChecking PHP extensions...\n";
$requiredExtensions = ['pdo', 'pdo_mysql', 'mbstring', 'openssl', 'tokenizer', 'xml', 'ctype', 'json', 'bcmath', 'gd'];
foreach ($requiredExtensions as $ext) {
    echo "  - $ext: ";
    if (extension_loaded($ext)) {
        echo "✓\n";
        $checks[] = "Extension $ext loaded";
    } else {
        echo "✗ MISSING\n";
        $errors[] = "Missing extension: $ext";
    }
}

// Check 3: .env file
echo "\nChecking .env file... ";
if (file_exists(__DIR__ . '/../.env')) {
    echo "✓ Found\n";
    $checks[] = ".env file exists";
    
    // Parse .env
    $envContent = file_get_contents(__DIR__ . '/../.env');
    
    // Check APP_ENV
    if (preg_match('/APP_ENV=(\w+)/', $envContent, $matches)) {
        $appEnv = $matches[1];
        echo "  APP_ENV: $appEnv ";
        if ($appEnv === 'production') {
            echo "✓\n";
        } else {
            echo "(not production)\n";
            $warnings[] = "APP_ENV is not set to production";
        }
    }
    
    // Check APP_DEBUG
    if (preg_match('/APP_DEBUG=(\w+)/', $envContent, $matches)) {
        $appDebug = $matches[1];
        echo "  APP_DEBUG: $appDebug ";
        if ($appDebug === 'false') {
            echo "✓\n";
        } else {
            echo "(should be false for production)\n";
            $warnings[] = "APP_DEBUG should be false for production testing";
        }
    }
    
    // Check Database
    if (preg_match('/DB_CONNECTION=(\w+)/', $envContent, $matches)) {
        $dbConnection = $matches[1];
        echo "  DB_CONNECTION: $dbConnection ✓\n";
    }
    
} else {
    echo "✗ NOT FOUND\n";
    $errors[] = ".env file not found";
}

// Check 4: Composer dependencies
echo "\nChecking Composer dependencies... ";
if (file_exists(__DIR__ . '/../vendor/autoload.php')) {
    echo "✓ Installed\n";
    $checks[] = "Composer dependencies installed";
} else {
    echo "✗ NOT INSTALLED\n";
    $errors[] = "Run 'composer install' first";
}

// Check 5: Node modules
echo "\nChecking Node modules... ";
if (file_exists(__DIR__ . '/../node_modules')) {
    echo "✓ Installed\n";
    $checks[] = "Node modules installed";
} else {
    echo "✗ NOT INSTALLED\n";
    $warnings[] = "Run 'npm install' to install frontend dependencies";
}

// Check 6: Compiled assets
echo "\nChecking compiled assets... ";
if (file_exists(__DIR__ . '/../public/build/manifest.json')) {
    echo "✓ Found\n";
    $checks[] = "Assets compiled";
} else {
    echo "✗ NOT FOUND\n";
    $warnings[] = "Run 'npm run build' to compile assets";
}

// Check 7: Storage permissions
echo "\nChecking storage permissions... ";
$storagePath = __DIR__ . '/../storage';
if (is_writable($storagePath)) {
    echo "✓ Writable\n";
    $checks[] = "Storage directory writable";
} else {
    echo "✗ NOT WRITABLE\n";
    $errors[] = "Storage directory not writable. Run: chmod -R 775 storage";
}

// Check 8: Storage link
echo "\nChecking storage link... ";
$publicStorage = __DIR__ . '/../public/storage';
if (is_link($publicStorage) || is_dir($publicStorage)) {
    echo "✓ Exists\n";
    $checks[] = "Storage link exists";
} else {
    echo "✗ NOT FOUND\n";
    $warnings[] = "Run 'php artisan storage:link' to create storage link";
}

// Check 9: Database connection
echo "\nChecking database connection... ";
try {
    require __DIR__ . '/../vendor/autoload.php';
    $app = require_once __DIR__ . '/../bootstrap/app.php';
    $kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
    $kernel->bootstrap();
    
    $pdo = DB::connection()->getPdo();
    echo "✓ Connected\n";
    $checks[] = "Database connection successful";
    
    // Check if tables exist
    echo "\nChecking database tables... ";
    try {
        $driver = DB::connection()->getDriverName();
        if ($driver === 'sqlite') {
            $tables = DB::select("SELECT name FROM sqlite_master WHERE type='table' AND name NOT LIKE 'sqlite_%'");
        } else {
            $tables = DB::select('SHOW TABLES');
        }
        
        if (count($tables) > 0) {
            echo "✓ " . count($tables) . " tables found\n";
            $checks[] = count($tables) . " database tables exist";
        } else {
            echo "✗ NO TABLES\n";
            $warnings[] = "Run 'php artisan migrate' to create tables";
        }
    } catch (Exception $e) {
        echo "✗ FAILED: " . $e->getMessage() . "\n";
        $errors[] = "Could not check tables: " . $e->getMessage();
    }
    
} catch (Exception $e) {
    echo "✗ FAILED: " . $e->getMessage() . "\n";
    $errors[] = "Database connection failed: " . $e->getMessage();
}

// Check 10: Cache directory
echo "\nChecking cache directory... ";
$cachePath = __DIR__ . '/../bootstrap/cache';
if (is_writable($cachePath)) {
    echo "✓ Writable\n";
    $checks[] = "Cache directory writable";
} else {
    echo "✗ NOT WRITABLE\n";
    $errors[] = "Cache directory not writable";
}

// Summary
echo "\n" . str_repeat("=", 60) . "\n";
echo "SUMMARY\n";
echo str_repeat("=", 60) . "\n";

echo "\n✓ Passed: " . count($checks) . "\n";
if (count($warnings) > 0) {
    echo "⚠ Warnings: " . count($warnings) . "\n";
    foreach ($warnings as $warning) {
        echo "  - $warning\n";
    }
}
if (count($errors) > 0) {
    echo "✗ Errors: " . count($errors) . "\n";
    foreach ($errors as $error) {
        echo "  - $error\n";
    }
}

echo "\n";

if (count($errors) > 0) {
    echo "❌ Setup verification FAILED. Please fix the errors above.\n";
    exit(1);
} elseif (count($warnings) > 0) {
    echo "⚠️  Setup verification PASSED with warnings.\n";
    exit(0);
} else {
    echo "✅ Setup verification PASSED. Ready for testing!\n";
    exit(0);
}
