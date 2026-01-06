# ✅ Seeder Setup Complete

## 🎉 Yang Sudah Dibuat

### 1. Current Data Seeder
**File:** `database/seeders/CurrentDataSeeder.php`

Seeder yang berisi data produksi saat ini:
- ✅ Settings (21 items)
- ✅ Hero Cards (1 item)
- ✅ Facilities (1 item)
- ✅ News (1 item)
- ✅ Tendik (1 item)

### 2. Storage Backup Command
**File:** `app/Console/Commands/BackupStorageCommand.php`

Command untuk backup dan restore storage:
```bash
php artisan storage:backup backup   # Backup
php artisan storage:backup restore  # Restore
```

### 3. Dokumentasi Lengkap

| File | Deskripsi |
|------|-----------|
| `QUICK_REFERENCE.md` | Quick reference untuk command-command penting |
| `MIGRATE_WITH_DATA.md` | Panduan lengkap migrate dengan data produksi |
| `SEEDER_DOCUMENTATION.md` | Dokumentasi lengkap tentang seeder |
| `database/seeders/README_CURRENT_DATA.md` | Info tentang CurrentDataSeeder |

### 4. Git Configuration
**File:** `.gitignore`

Ditambahkan:
```
/storage/app/public_backup
```

---

## 🚀 Cara Menggunakan

### Quick Start (One-Liner)

**Windows PowerShell:**
```powershell
php artisan storage:backup backup; php artisan migrate:fresh --seed --seeder=CurrentDataSeeder; php artisan storage:backup restore; php artisan storage:link
```

**Linux/Mac:**
```bash
php artisan storage:backup backup && php artisan migrate:fresh --seed --seeder=CurrentDataSeeder && php artisan storage:backup restore && php artisan storage:link
```

### Step by Step

```bash
# 1. Backup storage
php artisan storage:backup backup

# 2. Migrate fresh dengan data produksi
php artisan migrate:fresh --seed --seeder=CurrentDataSeeder

# 3. Restore storage
php artisan storage:backup restore

# 4. Recreate symbolic link
php artisan storage:link
```

---

## 📋 Checklist Penggunaan

Sebelum menjalankan migrate fresh/refresh:

- [ ] Backup storage: `php artisan storage:backup backup`
- [ ] Pastikan .env sudah dikonfigurasi dengan benar
- [ ] Pastikan database connection berfungsi
- [ ] Test di local environment dulu

Setelah migrate:

- [ ] Restore storage: `php artisan storage:backup restore`
- [ ] Recreate symbolic link: `php artisan storage:link`
- [ ] Test website apakah data sudah muncul
- [ ] Test upload file apakah berfungsi

---

## 🔄 Update Seeder di Masa Depan

Jika ada perubahan data dan ingin update seeder:

### 1. Export Data Terbaru
```bash
php artisan tinker --execute="echo json_encode(\App\Models\Setting::all()->toArray(), JSON_PRETTY_PRINT);" > settings.json
php artisan tinker --execute="echo json_encode(\App\Models\HeroCard::all()->toArray(), JSON_PRETTY_PRINT);" > hero_cards.json
php artisan tinker --execute="echo json_encode(\App\Models\News::all()->toArray(), JSON_PRETTY_PRINT);" > news.json
php artisan tinker --execute="echo json_encode(\App\Models\Facility::all()->toArray(), JSON_PRETTY_PRINT);" > facilities.json
php artisan tinker --execute="echo json_encode(\App\Models\Tendik::all()->toArray(), JSON_PRETTY_PRINT);" > tendik.json
```

### 2. Update CurrentDataSeeder.php
Edit file `database/seeders/CurrentDataSeeder.php` dengan data dari JSON.

### 3. Test
```bash
php artisan db:seed --class=CurrentDataSeeder
```

### 4. Commit
```bash
git add database/seeders/CurrentDataSeeder.php
git commit -m "Update current data seeder"
git push
```

---

## 📊 Data yang Tersimpan di Seeder

### Settings (21 items)
- university_name: "Sekolah Tinggi Teknologi Pratama Adi"
- university_short_name: "STT Pratama Adi"
- university_slogan: "Sekolah Tinggi Teknologi"
- logo: settings/01KE6FMBD45PQGQTD801DSNMAQ.png
- address, phone, email
- Social media URLs (Facebook, Instagram, YouTube)
- WhatsApp admin
- Registration fee, CBT settings
- Section titles & descriptions
- Campus images
- Maps embed

### Hero Cards (1 item)
- Title: "Selamat Datang di Duniaku"
- Subtitle: "RAWWWWR"
- Description: "lorem ipsum dolor sit amet"
- Background image
- Button: "Daftar Sekarang"
- Show logo: Yes

### News (1 item)
- Title: "test berita"
- Category: "Penelitian"
- Status: Published
- Thumbnail + Gallery images

### Facilities (1 item)
- Name: "test fasilitas"
- Description: "SIUUU"
- Status: Published
- Thumbnail + Gallery images

### Tendik (1 item)
- Name: "tes"
- NIDN: "123123123"
- Position: "Instruktur"
- Email: test@tendik.com
- Phone: 123123123
- Photo included

---

## ⚠️ Important Notes

1. **Seeder akan menghapus semua data** di tabel yang di-seed
2. **Backup storage** sebelum migrate fresh/refresh
3. **File storage tidak ter-commit** ke git (sudah ada di .gitignore)
4. **Backup storage** ada di `storage/app/public_backup/`
5. **Test di local** sebelum production

---

## 🆘 Troubleshooting

### Backup Failed
```bash
# Pastikan directory ada
mkdir storage/app/public
php artisan storage:link
```

### Seeder Failed
```bash
# Check database
php artisan db:show

# Check migrations
php artisan migrate:status
```

### Storage Link Missing
```bash
php artisan storage:link
```

---

## 📚 Dokumentasi Lengkap

Untuk informasi lebih detail, lihat:

1. **QUICK_REFERENCE.md** - Command reference cepat
2. **MIGRATE_WITH_DATA.md** - Panduan lengkap migrate
3. **SEEDER_DOCUMENTATION.md** - Dokumentasi seeder lengkap
4. **database/seeders/README_CURRENT_DATA.md** - Info CurrentDataSeeder

---

## ✨ Fitur Tambahan

### Storage Backup Command
Command custom yang dibuat untuk memudahkan backup/restore:

```bash
# Backup
php artisan storage:backup backup

# Restore
php artisan storage:backup restore
```

Backup disimpan di: `storage/app/public_backup/`

### Automatic Confirmation
Command akan menanyakan konfirmasi jika:
- Backup sudah ada (overwrite?)
- Restore akan overwrite storage yang ada

---

## 🎯 Next Steps

1. ✅ Test seeder di local environment
2. ✅ Backup storage sebelum migrate
3. ✅ Jalankan migrate fresh dengan seeder
4. ✅ Restore storage
5. ✅ Test website
6. ✅ Commit changes ke git

---

**Setup Date:** 2026-01-05
**Status:** ✅ Complete
**Version:** 1.0.0

---

## 🙏 Credits

Seeder ini dibuat berdasarkan data produksi yang ada di database pada tanggal 2026-01-05.

Untuk pertanyaan atau issue, hubungi tim development.
