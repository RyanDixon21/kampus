# Performance Testing Guide - STT Pratama Adi Website

## Overview
This guide provides instructions for performance testing the university website to ensure it meets the requirement of page load time < 3 seconds and handles multiple concurrent users.

## Requirements
- **Requirement 6.7**: Page load time < 3 seconds
- **Performance Goals**:
  - Homepage loads in < 3 seconds
  - Admin panel loads in < 3 seconds
  - Database queries optimized with eager loading
  - Images optimized and lazy loaded
  - Caching implemented for frequently accessed data

## Tools Required

### 1. Browser DevTools
- Chrome DevTools (Network, Performance, Lighthouse)
- Firefox Developer Tools
- Built-in browser tools for performance analysis

### 2. Apache Bench (ab)
```bash
# Install on Ubuntu/Debian
sudo apt-get install apache2-utils

# Install on macOS
brew install apache2
```

### 3. Laravel Debugbar (Optional)
```bash
composer require barryvdh/laravel-debugbar --dev
```

### 4. Lighthouse CI (Optional)
```bash
npm install -g @lhci/cli
```

## Performance Testing Procedures

## 1. Page Load Time Testing

### 1.1 Using Chrome DevTools

#### Homepage Performance
1. Open Chrome DevTools (F12)
2. Go to Network tab
3. Check "Disable cache"
4. Navigate to homepage
5. Wait for page to fully load
6. Check metrics:
   - **DOMContentLoaded**: Should be < 1.5s
   - **Load**: Should be < 3s
   - **Finish**: Total time for all resources

#### Metrics to Record
```
URL: /
DOMContentLoaded: _____ ms
Load: _____ ms
Finish: _____ ms
Total Requests: _____
Total Size: _____ MB
```

#### Admin Panel Performance
1. Login to admin panel
2. Clear cache
3. Navigate to dashboard
4. Record same metrics as above

### 1.2 Using Lighthouse

1. Open Chrome DevTools
2. Go to Lighthouse tab
3. Select:
   - Performance
   - Desktop/Mobile
4. Click "Generate report"
5. Review scores:
   - **Performance Score**: Target > 90
   - **First Contentful Paint**: < 1.8s
   - **Largest Contentful Paint**: < 2.5s
   - **Time to Interactive**: < 3.8s
   - **Speed Index**: < 3.4s
   - **Total Blocking Time**: < 200ms
   - **Cumulative Layout Shift**: < 0.1

#### Lighthouse Report Template
```
Date: _______________
URL: _______________

Performance Score: _____ / 100
First Contentful Paint: _____ s
Largest Contentful Paint: _____ s
Time to Interactive: _____ s
Speed Index: _____ s
Total Blocking Time: _____ ms
Cumulative Layout Shift: _____

Opportunities:
1. _______________________________________________
2. _______________________________________________
3. _______________________________________________

Diagnostics:
1. _______________________________________________
2. _______________________________________________
```

### 1.3 Network Throttling Test

Test with different connection speeds:

#### Fast 3G
1. Open DevTools Network tab
2. Select "Fast 3G" throttling
3. Reload page
4. Verify page still loads in reasonable time (< 5s)

#### Slow 3G
1. Select "Slow 3G" throttling
2. Reload page
3. Verify critical content loads first
4. Verify lazy loading works

## 2. Concurrent User Testing

### 2.1 Using Apache Bench

#### Test Homepage
```bash
# 100 requests, 10 concurrent users
ab -n 100 -c 10 http://localhost:8000/

# 500 requests, 50 concurrent users
ab -n 500 -c 50 http://localhost:8000/

# 1000 requests, 100 concurrent users
ab -n 1000 -c 100 http://localhost:8000/
```

#### Metrics to Analyze
- **Requests per second**: Higher is better
- **Time per request**: Should be < 3000ms
- **Failed requests**: Should be 0
- **Transfer rate**: Check bandwidth usage

#### Expected Results Template
```
Test: Homepage Load Test
Date: _______________
Command: ab -n 500 -c 50 http://localhost:8000/

Concurrency Level: 50
Time taken for tests: _____ seconds
Complete requests: 500
Failed requests: _____
Requests per second: _____ [#/sec]
Time per request: _____ [ms] (mean)
Time per request: _____ [ms] (mean, across all concurrent requests)
Transfer rate: _____ [Kbytes/sec]

Percentage of requests served within a certain time (ms)
  50%  _____
  66%  _____
  75%  _____
  80%  _____
  90%  _____
  95%  _____
  98%  _____
  99%  _____
 100%  _____ (longest request)

Status: PASS / FAIL
Notes: _______________________________________________
```

### 2.2 Test Registration Endpoint

```bash
# Test registration form submission
ab -n 100 -c 10 -p registration.json -T application/json http://localhost:8000/registration
```

Create `registration.json`:
```json
{
  "name": "Test User",
  "email": "test@example.com",
  "phone": "081234567890",
  "address": "Test Address"
}
```

### 2.3 Test Admin Panel

```bash
# Test admin dashboard (requires authentication)
# First get auth cookie, then:
ab -n 100 -c 10 -C "laravel_session=YOUR_SESSION_COOKIE" http://localhost:8000/admin
```

## 3. Database Query Performance

### 3.1 Using Laravel Debugbar

1. Install Laravel Debugbar (if not installed)
2. Enable in `.env`: `DEBUGBAR_ENABLED=true`
3. Navigate to pages
4. Check Debugbar at bottom of page
5. Review "Queries" tab

#### Metrics to Check
- **Total Queries**: Should be minimal (< 20 for most pages)
- **Query Time**: Total time should be < 100ms
- **Duplicate Queries**: Should be 0
- **N+1 Issues**: Should be 0

#### Query Analysis Template
```
Page: _______________
Total Queries: _____
Total Query Time: _____ ms
Duplicate Queries: _____
N+1 Issues: _____

Slow Queries (> 10ms):
1. _______________________________________________
2. _______________________________________________

Recommendations:
1. _______________________________________________
2. _______________________________________________
```

### 3.2 Using Laravel Telescope (Optional)

1. Install Telescope: `composer require laravel/telescope`
2. Run: `php artisan telescope:install`
3. Navigate to `/telescope`
4. Review "Queries" section
5. Identify slow queries
6. Check for N+1 problems

## 4. Caching Performance

### 4.1 Test Cache Hit Rate

#### Settings Cache Test
```bash
# Run this in tinker: php artisan tinker

# First access (cache miss)
$start = microtime(true);
$settings = Setting::getSettings();
$time1 = (microtime(true) - $start) * 1000;
echo "First access (cache miss): {$time1}ms\n";

# Second access (cache hit)
$start = microtime(true);
$settings = Setting::getSettings();
$time2 = (microtime(true) - $start) * 1000;
echo "Second access (cache hit): {$time2}ms\n";

# Cache hit should be significantly faster
echo "Speedup: " . ($time1 / $time2) . "x\n";
```

#### Expected Results
- Cache miss: 10-50ms (database query)
- Cache hit: < 1ms (memory access)
- Speedup: > 10x

### 4.2 Test Cache Invalidation

```bash
# In tinker
# Get cached value
$value1 = Setting::get('university_name');

# Update setting
Setting::set('university_name', 'New Name');

# Get value again (should be new value, not cached)
$value2 = Setting::get('university_name');

# Verify cache was invalidated
echo $value1 === $value2 ? "FAIL: Cache not invalidated" : "PASS: Cache invalidated";
```

## 5. Image Optimization Testing

### 5.1 Check Image Sizes

1. Navigate to homepage
2. Open DevTools Network tab
3. Filter by "Img"
4. Check each image:
   - File size should be < 200KB for thumbnails
   - File size should be < 500KB for hero images
   - Format should be JPG or WebP
   - Dimensions should match display size

#### Image Audit Template
```
Image: _______________
Original Size: _____ KB
Optimized Size: _____ KB
Compression Ratio: _____ %
Format: _____
Dimensions: _____ x _____
Display Size: _____ x _____
Status: PASS / FAIL
```

### 5.2 Test Lazy Loading

1. Open DevTools Network tab
2. Navigate to homepage
3. Check images loaded initially
4. Scroll down slowly
5. Verify images load as they come into viewport
6. Check "Initiator" column shows lazy loading

## 6. Asset Optimization Testing

### 6.1 Check CSS/JS Minification

1. View page source
2. Check CSS files:
   - Should be minified (no whitespace)
   - Should be combined (few files)
3. Check JS files:
   - Should be minified
   - Should be combined

### 6.2 Check Asset Caching

1. Open DevTools Network tab
2. Load page first time
3. Reload page
4. Check "Size" column:
   - Should show "(disk cache)" or "(memory cache)"
   - Indicates browser caching working

## 7. Performance Benchmarks

### Target Metrics

| Metric | Target | Critical |
|--------|--------|----------|
| Homepage Load Time | < 3s | < 5s |
| Admin Dashboard Load Time | < 3s | < 5s |
| Time to First Byte (TTFB) | < 200ms | < 500ms |
| First Contentful Paint | < 1.8s | < 3s |
| Largest Contentful Paint | < 2.5s | < 4s |
| Total Blocking Time | < 200ms | < 600ms |
| Cumulative Layout Shift | < 0.1 | < 0.25 |
| Database Queries per Page | < 20 | < 50 |
| Query Time | < 100ms | < 500ms |
| Image Size (thumbnail) | < 200KB | < 500KB |
| Concurrent Users | 100+ | 50+ |
| Requests per Second | 50+ | 20+ |

## 8. Performance Testing Checklist

### Pre-Test Setup
- [ ] Application running in production mode (`APP_ENV=production`)
- [ ] Debug mode disabled (`APP_DEBUG=false`)
- [ ] Cache enabled and warmed up
- [ ] Database seeded with realistic data
- [ ] All assets compiled (`npm run build`)
- [ ] Opcache enabled (PHP)

### Tests to Run
- [ ] Homepage load time (Chrome DevTools)
- [ ] Admin panel load time (Chrome DevTools)
- [ ] Lighthouse performance audit
- [ ] Network throttling test (Fast 3G)
- [ ] Concurrent user test (Apache Bench)
- [ ] Database query analysis (Debugbar)
- [ ] Cache performance test
- [ ] Image optimization check
- [ ] Asset minification check

### Post-Test Analysis
- [ ] All metrics meet targets
- [ ] No critical performance issues
- [ ] Optimization opportunities identified
- [ ] Action items documented

## 9. Common Performance Issues and Solutions

### Issue: Slow Page Load
**Symptoms**: Page takes > 3s to load
**Solutions**:
- Enable caching
- Optimize images
- Minify CSS/JS
- Enable compression (gzip)
- Use CDN for assets

### Issue: Too Many Database Queries
**Symptoms**: > 50 queries per page
**Solutions**:
- Use eager loading (`with()`)
- Cache query results
- Optimize query logic
- Add database indexes

### Issue: Large Image Files
**Symptoms**: Images > 500KB
**Solutions**:
- Compress images
- Use appropriate formats (WebP)
- Resize to display dimensions
- Implement lazy loading

### Issue: Slow Database Queries
**Symptoms**: Queries taking > 100ms
**Solutions**:
- Add indexes to frequently queried columns
- Optimize WHERE clauses
- Use query caching
- Consider database optimization

## 10. Performance Test Report Template

```
# Performance Test Report
Date: _______________
Tester: _______________
Environment: Production / Staging / Local

## Summary
Overall Status: PASS / FAIL
Critical Issues: _____
Warnings: _____

## Page Load Times
| Page | Load Time | Status |
|------|-----------|--------|
| Homepage | _____ s | PASS/FAIL |
| Admin Dashboard | _____ s | PASS/FAIL |
| Registration | _____ s | PASS/FAIL |
| CBT Exam | _____ s | PASS/FAIL |

## Lighthouse Scores
| Metric | Score | Status |
|--------|-------|--------|
| Performance | _____ | PASS/FAIL |
| Accessibility | _____ | PASS/FAIL |
| Best Practices | _____ | PASS/FAIL |
| SEO | _____ | PASS/FAIL |

## Concurrent User Test
Concurrent Users: _____
Requests per Second: _____
Average Response Time: _____ ms
Failed Requests: _____
Status: PASS / FAIL

## Database Performance
Average Queries per Page: _____
Average Query Time: _____ ms
N+1 Issues Found: _____
Status: PASS / FAIL

## Caching Performance
Cache Hit Rate: _____ %
Cache Speedup: _____ x
Status: PASS / FAIL

## Issues Found
1. _______________________________________________
   Severity: Critical / High / Medium / Low
   Solution: _______________________________________________

2. _______________________________________________
   Severity: Critical / High / Medium / Low
   Solution: _______________________________________________

## Recommendations
1. _______________________________________________
2. _______________________________________________
3. _______________________________________________

## Sign-off
- [ ] All performance targets met
- [ ] Critical issues resolved
- [ ] Ready for production
```

## Next Steps

After completing performance testing:
1. Document all results
2. Address critical issues
3. Implement recommended optimizations
4. Re-test after optimizations
5. Get sign-off from stakeholders
