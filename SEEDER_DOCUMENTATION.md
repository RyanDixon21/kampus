# Dokumentasi Seeder - STT Pratama Adi

## Overview

Project ini memiliki 2 jenis seeder:

### 1. Sample Data Seeder (Default)
Seeder dengan data contoh/dummy untuk development.

**File:** `DatabaseSeeder.php`

**Cara Jalankan:**
```bash
php artisan migrate:fresh --seed
```

**Berisi:**
- AdminUserSeeder - User admin default
- SettingsSeeder - Setting dasar
- HeroCardSeeder - Hero slide contoh
- SampleDataSeeder - Data sample (news, facilities, tendik)

### 2. Current Data Seeder (Production)
Seeder dengan data produksi yang sedang digunakan saat ini.

**File:** `CurrentDataSeeder.php`

**Cara Jalankan:**
```bash
php artisan db:seed --class=CurrentDataSeeder
```

**Berisi:**
- Settings (21 items) - Data konfigurasi aktual
- Hero Cards (1 item) - Hero slide produksi
- News (1 item) - Berita aktual
- Facilities (1 item) - Fasilitas aktual
- Tendik (1 item) - Data tendik aktual

## Kapan Menggunakan Seeder Mana?

### Gunakan Sample Data Seeder Ketika:
- ✓ Development baru
- ✓ Testing fitur baru
- ✓ Tidak perlu data produksi
- ✓ Ingin data dummy yang banyak

### Gunakan Current Data Seeder Ketika:
- ✓ Restore data produksi
- ✓ Setup environment baru dengan data produksi
- ✓ Setelah migrate fresh di production
- ✓ Recovery dari backup

## Command Reference

### Database Seeding

```bash
# Seed dengan data sample (default)
php artisan db:seed

# Seed dengan data produksi
php artisan db:seed --class=CurrentDataSeeder

# Migrate fresh + seed sample
php artisan migrate:fresh --seed

# Migrate fresh + seed produksi
php artisan migrate:fresh --seed --seeder=CurrentDataSeeder

# Migrate refresh + seed produksi
php artisan migrate:refresh --seed --seeder=CurrentDataSeeder
```

### Storage Backup

```bash
# Backup storage
php artisan storage:backup backup

# Restore storage
php artisan storage:backup restore
```

## Workflow Production

### Full Reset dengan Data Produksi

```bash
# 1. Backup storage files
php artisan storage:backup backup

# 2. Reset database dan seed data produksi
php artisan migrate:fresh --seed --seeder=CurrentDataSeeder

# 3. Restore storage files
php artisan storage:backup restore

# 4. Recreate symbolic link
php artisan storage:link
```

### One-Liner (Windows PowerShell)
```powershell
php artisan storage:backup backup; php artisan migrate:fresh --seed --seeder=CurrentDataSeeder; php artisan storage:backup restore; php artisan storage:link
```

### One-Liner (Linux/Mac)
```bash
php artisan storage:backup backup && php artisan migrate:fresh --seed --seeder=CurrentDataSeeder && php artisan storage:backup restore && php artisan storage:link
```

## Update Current Data Seeder

Jika ada perubahan data produksi dan ingin update seeder:

### 1. Export Data Terbaru

```bash
# Settings
php artisan tinker --execute="echo json_encode(\App\Models\Setting::all()->toArray(), JSON_PRETTY_PRINT);"

# Hero Cards
php artisan tinker --execute="echo json_encode(\App\Models\HeroCard::all()->toArray(), JSON_PRETTY_PRINT);"

# News
php artisan tinker --execute="echo json_encode(\App\Models\News::all()->toArray(), JSON_PRETTY_PRINT);"

# Facilities
php artisan tinker --execute="echo json_encode(\App\Models\Facility::all()->toArray(), JSON_PRETTY_PRINT);"

# Tendik
php artisan tinker --execute="echo json_encode(\App\Models\Tendik::all()->toArray(), JSON_PRETTY_PRINT);"
```

### 2. Update Seeder File

Edit `database/seeders/CurrentDataSeeder.php` dengan data baru.

### 3. Commit ke Git

```bash
git add database/seeders/CurrentDataSeeder.php
git commit -m "Update current data seeder with latest production data"
```

## File Structure

```
database/seeders/
├── AdminUserSeeder.php          # Admin user (email: admin@admin.com, pass: password)
├── DatabaseSeeder.php           # Main seeder (sample data)
├── CurrentDataSeeder.php        # Production data seeder ⭐
├── HeroCardSeeder.php          # Sample hero cards
├── SampleDataSeeder.php        # Sample news, facilities, tendik
├── SettingsSeeder.php          # Basic settings
├── README.md                   # General seeder info
└── README_CURRENT_DATA.md      # Current data seeder info
```

## Important Notes

### ⚠️ Warning

1. **CurrentDataSeeder akan menghapus semua data** di tabel yang di-seed
2. **Selalu backup storage** sebelum migrate fresh/refresh
3. **Test di local** sebelum jalankan di production
4. **Pastikan file storage ada** sebelum restore

### 📝 Best Practices

1. Backup storage sebelum migrate
2. Gunakan version control untuk seeder
3. Dokumentasikan perubahan data
4. Test seeder di environment staging
5. Simpan backup di multiple locations

### 🔒 Security

1. Jangan commit file storage ke git
2. Gunakan `.gitignore` untuk storage files
3. Backup storage ke secure location
4. Encrypt sensitive data jika perlu

## Troubleshooting

### Storage Backup Failed
```bash
# Pastikan directory ada
mkdir storage/app/public

# Buat symbolic link
php artisan storage:link
```

### Seeder Failed
```bash
# Check database connection
php artisan db:show

# Check migrations
php artisan migrate:status

# Run migrations
php artisan migrate
```

### Foreign Key Constraint Error
```bash
# Seeder sudah handle ini dengan:
DB::statement('SET FOREIGN_KEY_CHECKS=0;');
# ... truncate tables ...
DB::statement('SET FOREIGN_KEY_CHECKS=1;');
```

## Support

Untuk pertanyaan atau issue, hubungi tim development atau buat issue di repository.

---

**Last Updated:** 2026-01-05
**Version:** 1.0.0
