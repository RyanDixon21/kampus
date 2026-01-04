# Quick Start - Testing Guide

## 🚀 Fast Track Testing

### 1️⃣ Verify Setup (30 seconds)
```bash
php tests/verify-setup.php
```
**Expected:** All checks pass (warnings OK for local environment)

### 2️⃣ Run Performance Tests (1 minute)
```bash
php tests/performance-test.php
```
**Expected:** 9/9 tests pass

### 3️⃣ Run Load Tests (5 minutes)

**Windows:**
```cmd
tests\load-test.bat
```

**Linux/Mac:**
```bash
chmod +x tests/load-test.sh
./tests/load-test.sh http://localhost:8000
```
**Expected:** All tests complete with < 3000ms response time

### 4️⃣ Manual Testing (2-4 hours)
Open and follow: `tests/manual-testing-checklist.md`

### 5️⃣ Document Results
Fill out: `tests/PERFORMANCE-REPORT-TEMPLATE.md`

---

## 📋 What to Test

### Critical Features (Must Test)
- [ ] Admin login and authentication
- [ ] Settings management (logo, contact info)
- [ ] News CRUD operations
- [ ] Registration flow (form → payment → WhatsApp)
- [ ] CBT login and exam
- [ ] Homepage loads in < 3 seconds
- [ ] Responsive design (mobile, tablet, desktop)

### Performance Checks (Must Pass)
- [ ] Page load < 3 seconds
- [ ] Database queries < 20 per page
- [ ] Cache working (18x+ speedup)
- [ ] Images optimized (< 200KB thumbnails)
- [ ] 100+ concurrent users supported

---

## 🔧 Troubleshooting

### Issue: Tests Fail
**Solution:** Check `.env` configuration and database connection

### Issue: Load Test Fails
**Solution:** Ensure server is running: `php artisan serve`

### Issue: Performance Slow
**Solutions:**
- Clear cache: `php artisan cache:clear`
- Compile assets: `npm run build`
- Enable opcache in `php.ini`

---

## 📊 Success Criteria

✅ All automated tests pass  
✅ Page load time < 3 seconds  
✅ No critical bugs in manual testing  
✅ 100+ concurrent users supported  
✅ All features work as expected  

---

## 📚 Full Documentation

- **Complete Guide:** `tests/README-TESTING.md`
- **Manual Testing:** `tests/manual-testing-checklist.md`
- **Performance Guide:** `tests/performance-testing-guide.md`
- **Report Template:** `tests/PERFORMANCE-REPORT-TEMPLATE.md`

---

## ⏱️ Time Estimates

| Task | Time |
|------|------|
| Setup verification | 30 seconds |
| Automated performance tests | 1 minute |
| Load tests | 5 minutes |
| Manual testing (full) | 2-4 hours |
| Performance analysis | 1-2 hours |
| Documentation | 1 hour |
| **Total** | **4-8 hours** |

---

## 🎯 Quick Wins

Before testing, ensure:
1. ✅ `APP_ENV=production` in `.env`
2. ✅ `APP_DEBUG=false` in `.env`
3. ✅ Assets compiled: `npm run build`
4. ✅ Cache cleared: `php artisan cache:clear`
5. ✅ Database seeded: `php artisan db:seed`

---

**Need Help?** See `tests/README-TESTING.md` for detailed instructions.
