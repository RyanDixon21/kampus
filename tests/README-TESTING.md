# Testing Documentation - STT Pratama Adi Website

## Overview

This directory contains comprehensive testing documentation and scripts for the university website. The testing suite covers manual testing, performance testing, load testing, and automated verification.

## Testing Files

### 1. Manual Testing
- **`manual-testing-checklist.md`** - Comprehensive checklist for manual browser testing
  - Admin panel testing
  - Frontend testing
  - Registration flow testing
  - CBT system testing
  - Cross-browser testing
  - Security testing
  - Error handling

### 2. Performance Testing
- **`performance-testing-guide.md`** - Complete guide for performance testing
  - Page load time testing
  - Concurrent user testing
  - Database query performance
  - Caching performance
  - Image optimization
  - Asset optimization

- **`performance-test.php`** - Automated PHP performance test script
  - Cache performance tests
  - Database query tests
  - Memory usage tests
  - Connection pool tests

- **`PERFORMANCE-REPORT-TEMPLATE.md`** - Template for documenting performance test results

### 3. Load Testing
- **`load-test.sh`** - Bash script for load testing (Linux/Mac)
- **`load-test.bat`** - Batch script for load testing (Windows)
- **`load-test-results/`** - Directory for storing load test results

### 4. Setup Verification
- **`verify-setup.php`** - Script to verify application setup before testing
  - PHP version check
  - Extension checks
  - Environment configuration
  - Database connection
  - File permissions

## Quick Start

### 1. Verify Setup

Before running any tests, verify your setup:

```bash
php tests/verify-setup.php
```

This will check:
- PHP version and extensions
- Environment configuration
- Database connection
- File permissions
- Compiled assets

### 2. Run Performance Tests

Run automated performance tests:

```bash
php tests/performance-test.php
```

This tests:
- Cache performance
- Database queries
- Memory usage
- Query optimization

### 3. Run Load Tests

#### On Linux/Mac:
```bash
chmod +x tests/load-test.sh
./tests/load-test.sh http://localhost:8000
```

#### On Windows:
```cmd
tests\load-test.bat
```

This performs:
- Light load testing (100 requests, 10 concurrent)
- Medium load testing (500 requests, 50 concurrent)
- Heavy load testing (1000 requests, 100 concurrent)

### 4. Manual Testing

Follow the comprehensive checklist:

```bash
# Open the manual testing checklist
cat tests/manual-testing-checklist.md
```

Or open in your preferred markdown viewer.

### 5. Performance Testing

Follow the performance testing guide:

```bash
# Open the performance testing guide
cat tests/performance-testing-guide.md
```

## Testing Workflow

### Pre-Deployment Testing

1. **Setup Verification**
   ```bash
   php tests/verify-setup.php
   ```

2. **Automated Performance Tests**
   ```bash
   php tests/performance-test.php
   ```

3. **Load Testing**
   ```bash
   ./tests/load-test.sh
   ```

4. **Manual Testing**
   - Follow `manual-testing-checklist.md`
   - Test all features systematically
   - Document any issues found

5. **Performance Analysis**
   - Use Chrome DevTools
   - Run Lighthouse audits
   - Follow `performance-testing-guide.md`

6. **Documentation**
   - Fill out `PERFORMANCE-REPORT-TEMPLATE.md`
   - Document all test results
   - Get sign-off from stakeholders

## Performance Requirements

### Key Metrics (Requirement 6.7)

| Metric | Target | Critical |
|--------|--------|----------|
| Page Load Time | < 3s | < 5s |
| Time to First Byte | < 200ms | < 500ms |
| First Contentful Paint | < 1.8s | < 3s |
| Largest Contentful Paint | < 2.5s | < 4s |
| Database Queries | < 20/page | < 50/page |
| Query Time | < 100ms | < 500ms |
| Concurrent Users | 100+ | 50+ |
| Requests per Second | 50+ | 20+ |

## Tools Required

### Essential Tools
- **PHP 8.2+** - For running PHP scripts
- **Composer** - For dependencies
- **Chrome/Firefox** - For browser testing
- **Chrome DevTools** - For performance analysis

### Optional Tools
- **Apache Bench (ab)** - For load testing
  - Ubuntu/Debian: `sudo apt-get install apache2-utils`
  - macOS: `brew install apache2`
  - Windows: Download Apache HTTP Server

- **Laravel Debugbar** - For query analysis
  ```bash
  composer require barryvdh/laravel-debugbar --dev
  ```

- **Lighthouse CI** - For automated audits
  ```bash
  npm install -g @lhci/cli
  ```

## Test Results Location

All test results are saved in:
- **Load test results:** `tests/load-test-results/`
- **Performance reports:** Document in `PERFORMANCE-REPORT-TEMPLATE.md`
- **Manual test results:** Document in `manual-testing-checklist.md`

## Continuous Integration

### Automated Testing in CI/CD

Add to your CI/CD pipeline:

```yaml
# Example GitHub Actions workflow
- name: Verify Setup
  run: php tests/verify-setup.php

- name: Run Performance Tests
  run: php tests/performance-test.php

- name: Run Unit Tests
  run: php artisan test

- name: Run Load Tests
  run: ./tests/load-test.sh http://localhost:8000
```

## Troubleshooting

### Common Issues

#### 1. Apache Bench Not Found
**Solution:** Install Apache HTTP Server or use the PHP performance test instead:
```bash
php tests/performance-test.php
```

#### 2. Database Connection Failed
**Solution:** Check your `.env` file and ensure database is running:
```bash
php artisan migrate:status
```

#### 3. Storage Not Writable
**Solution:** Fix permissions:
```bash
chmod -R 775 storage bootstrap/cache
```

#### 4. Assets Not Compiled
**Solution:** Build assets:
```bash
npm run build
```

#### 5. Page Load Time > 3s
**Possible causes:**
- Images not optimized
- Cache not enabled
- Too many database queries
- Assets not minified

**Solutions:**
- Run image optimization
- Enable caching in `.env`
- Use eager loading for relationships
- Run `npm run build` for production

## Best Practices

### Before Testing
1. ✅ Set `APP_ENV=production` in `.env`
2. ✅ Set `APP_DEBUG=false` in `.env`
3. ✅ Clear and warm up cache: `php artisan cache:clear && php artisan config:cache`
4. ✅ Compile assets: `npm run build`
5. ✅ Seed database with realistic data
6. ✅ Enable opcache for PHP

### During Testing
1. ✅ Test on clean browser (clear cache)
2. ✅ Test with different network speeds
3. ✅ Test on multiple devices
4. ✅ Document all findings
5. ✅ Take screenshots of issues
6. ✅ Record performance metrics

### After Testing
1. ✅ Document all results
2. ✅ Create action items for issues
3. ✅ Prioritize optimizations
4. ✅ Re-test after fixes
5. ✅ Get stakeholder sign-off

## Performance Optimization Tips

### Quick Wins
1. **Enable Caching**
   ```php
   // In .env
   CACHE_DRIVER=redis  // or file
   ```

2. **Optimize Images**
   - Use ImageService for all uploads
   - Implement lazy loading
   - Use WebP format

3. **Database Optimization**
   - Use eager loading: `->with('relation')`
   - Add indexes to frequently queried columns
   - Cache query results

4. **Asset Optimization**
   - Minify CSS/JS: `npm run build`
   - Enable compression (gzip)
   - Use CDN for static assets

5. **Enable Opcache**
   ```ini
   ; In php.ini
   opcache.enable=1
   opcache.memory_consumption=128
   opcache.max_accelerated_files=10000
   ```

## Support

For questions or issues with testing:
1. Review this documentation
2. Check the troubleshooting section
3. Review Laravel documentation
4. Contact the development team

## Version History

- **v1.0** - Initial testing documentation
  - Manual testing checklist
  - Performance testing guide
  - Load testing scripts
  - Setup verification
  - Performance report template

## License

This testing documentation is part of the STT Pratama Adi website project.
