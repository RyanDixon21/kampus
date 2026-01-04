@echo off
REM Load Testing Script for STT Pratama Adi Website (Windows)
REM This script provides instructions for load testing on Windows
REM 
REM Usage: tests\load-test.bat

echo ==========================================
echo Load Testing - STT Pratama Adi Website
echo ==========================================
echo.

REM Check if Apache Bench is available
where ab >nul 2>nul
if %ERRORLEVEL% NEQ 0 (
    echo [ERROR] Apache Bench (ab) is not installed or not in PATH
    echo.
    echo To install Apache Bench on Windows:
    echo   1. Download Apache HTTP Server from https://www.apachelounge.com/download/
    echo   2. Extract the ZIP file
    echo   3. Add the bin directory to your PATH
    echo   4. Or use the full path to ab.exe
    echo.
    echo Alternative: Use the PHP performance test instead:
    echo   php tests/performance-test.php
    echo.
    pause
    exit /b 1
)

echo Apache Bench found!
echo.

REM Set configuration
set BASE_URL=http://localhost:8000
set RESULTS_DIR=tests\load-test-results
set TIMESTAMP=%date:~-4%%date:~3,2%%date:~0,2%_%time:~0,2%%time:~3,2%%time:~6,2%
set TIMESTAMP=%TIMESTAMP: =0%

REM Create results directory
if not exist "%RESULTS_DIR%" mkdir "%RESULTS_DIR%"

echo Base URL: %BASE_URL%
echo Results directory: %RESULTS_DIR%
echo Timestamp: %TIMESTAMP%
echo.

REM Check if server is running
echo Checking if server is running...
curl -s -o nul -w "%%{http_code}" %BASE_URL% | findstr "200 302" >nul
if %ERRORLEVEL% NEQ 0 (
    echo [ERROR] Server is not responding at %BASE_URL%
    echo Please start the server first: php artisan serve
    echo.
    pause
    exit /b 1
)
echo Server is running!
echo.

echo ==========================================
echo Running Load Tests
echo ==========================================
echo.

REM Test 1: Homepage - Light Load
echo Test 1: Homepage - Light Load (100 requests, 10 concurrent)
ab -n 100 -c 10 %BASE_URL%/ > "%RESULTS_DIR%\%TIMESTAMP%_homepage_light.txt" 2>&1
echo   Results saved to: %RESULTS_DIR%\%TIMESTAMP%_homepage_light.txt
echo.

REM Test 2: Homepage - Medium Load
echo Test 2: Homepage - Medium Load (500 requests, 50 concurrent)
ab -n 500 -c 50 %BASE_URL%/ > "%RESULTS_DIR%\%TIMESTAMP%_homepage_medium.txt" 2>&1
echo   Results saved to: %RESULTS_DIR%\%TIMESTAMP%_homepage_medium.txt
echo.

REM Test 3: Homepage - Heavy Load
echo Test 3: Homepage - Heavy Load (1000 requests, 100 concurrent)
ab -n 1000 -c 100 %BASE_URL%/ > "%RESULTS_DIR%\%TIMESTAMP%_homepage_heavy.txt" 2>&1
echo   Results saved to: %RESULTS_DIR%\%TIMESTAMP%_homepage_heavy.txt
echo.

REM Test 4: Admin Login Page
echo Test 4: Admin Login Page (100 requests, 10 concurrent)
ab -n 100 -c 10 %BASE_URL%/admin/login > "%RESULTS_DIR%\%TIMESTAMP%_admin_login.txt" 2>&1
echo   Results saved to: %RESULTS_DIR%\%TIMESTAMP%_admin_login.txt
echo.

REM Test 5: Registration Page
echo Test 5: Registration Page (100 requests, 10 concurrent)
ab -n 100 -c 10 %BASE_URL%/registration/create > "%RESULTS_DIR%\%TIMESTAMP%_registration.txt" 2>&1
echo   Results saved to: %RESULTS_DIR%\%TIMESTAMP%_registration.txt
echo.

echo ==========================================
echo Load Testing Complete
echo ==========================================
echo.
echo Results saved to: %RESULTS_DIR%
echo.
echo To view detailed results, open the text files in: %RESULTS_DIR%
echo.
echo Summary of key metrics:
echo.

REM Extract and display key metrics from the heavy load test
findstr /C:"Requests per second" "%RESULTS_DIR%\%TIMESTAMP%_homepage_heavy.txt"
findstr /C:"Time per request" "%RESULTS_DIR%\%TIMESTAMP%_homepage_heavy.txt"
findstr /C:"Failed requests" "%RESULTS_DIR%\%TIMESTAMP%_homepage_heavy.txt"

echo.
pause
