# Migrate dengan Data Produksi

Panduan lengkap untuk melakukan migrate fresh/refresh dengan tetap mempertahankan data produksi.

## Quick Start

### 1. Backup Storage

```bash
php artisan storage:backup backup
```

### 2. Migrate Fresh dengan Data

```bash
php artisan migrate:fresh --seed --seeder=CurrentDataSeeder
```

### 3. Restore Storage

```bash
php artisan storage:backup restore
```

## Command yang Tersedia

### Storage Backup Command

#### Backup Storage
```bash
php artisan storage:backup backup
```
Membuat backup dari `storage/app/public` ke `storage/app/public_backup`

#### Restore Storage
```bash
php artisan storage:backup restore
```
Mengembalikan storage dari backup `storage/app/public_backup` ke `storage/app/public`

### Database Seeder

#### Seed Data Produksi
```bash
php artisan db:seed --class=CurrentDataSeeder
```
Mengisi database dengan data produksi yang sudah ada

## Workflow Lengkap

### Scenario 1: Migrate Fresh (Hapus semua tabel dan buat ulang)

```bash
# 1. Backup storage
php artisan storage:backup backup

# 2. Migrate fresh dengan seeder
php artisan migrate:fresh --seed --seeder=CurrentDataSeeder

# 3. Restore storage
php artisan storage:backup restore

# 4. Recreate symbolic link jika perlu
php artisan storage:link
```

### Scenario 2: Migrate Refresh (Rollback dan migrate ulang)

```bash
# 1. Backup storage
php artisan storage:backup backup

# 2. Migrate refresh dengan seeder
php artisan migrate:refresh --seed --seeder=CurrentDataSeeder

# 3. Restore storage
php artisan storage:backup restore
```

### Scenario 3: Hanya Seed Data (Database sudah di-migrate)

```bash
php artisan db:seed --class=CurrentDataSeeder
```

## One-Liner Commands

### Windows (PowerShell)
```powershell
php artisan storage:backup backup; php artisan migrate:fresh --seed --seeder=CurrentDataSeeder; php artisan storage:backup restore; php artisan storage:link
```

### Linux/Mac (Bash)
```bash
php artisan storage:backup backup && php artisan migrate:fresh --seed --seeder=CurrentDataSeeder && php artisan storage:backup restore && php artisan storage:link
```

## Data yang Di-seed

CurrentDataSeeder akan mengisi:

- ✓ **Settings** (21 items) - Konfigurasi website
- ✓ **Hero Cards** (1 item) - Slide hero section
- ✓ **News** (1 item) - Berita
- ✓ **Facilities** (1 item) - Fasilitas
- ✓ **Tendik** (1 item) - Tenaga kependidikan

## File Storage yang Dibutuhkan

Seeder ini membutuhkan file-file berikut di storage:

```
storage/app/public/
├── settings/
│   ├── 01KE6FMBD45PQGQTD801DSNMAQ.png (Logo)
│   └── campus/
│       ├── 01KE6KYF61MYMMB6Q09ZCABRDB.jpg
│       └── 01KE6KYF6811SP935M9JHB2A0K.jpg
├── hero-slides/
│   └── 01KE6FVV4F2TXGM5F6VYPJ1EEN.jpg
├── news/
│   ├── thumbnails/
│   │   └── 01KE6HB7VDJDDSYNF8M5XS3VGG.jpg
│   └── gallery/
│       └── 01KE6HB7VMBZ68T61STBRG3KAA.jpg
├── facilities/
│   ├── thumbnails/
│   │   └── 01KE6HDQ1XG9HGYN28PF0JG5JC.png
│   └── gallery/
│       └── 01KE6HDQ271BEYR5YBQ2XWEH93.jpg
└── tendik/
    └── 01KE6KP830AD6ETC27SZ1QD7PP.jpg
```

## Troubleshooting

### Error: Backup directory already exists

Jika backup sudah ada, command akan menanyakan apakah ingin overwrite:
```
Backup directory already exists. Overwrite? (yes/no) [no]:
```

Ketik `yes` untuk overwrite atau `no` untuk cancel.

### Error: Source directory does not exist

Pastikan `storage/app/public` ada. Jika tidak, buat dengan:
```bash
mkdir storage/app/public
php artisan storage:link
```

### Error: Backup directory does not exist

Anda belum membuat backup. Jalankan:
```bash
php artisan storage:backup backup
```

### Symbolic Link Hilang

Setelah migrate fresh, symbolic link mungkin hilang. Buat ulang dengan:
```bash
php artisan storage:link
```

## Update Seeder dengan Data Terbaru

Jika ada perubahan data dan ingin update seeder:

### 1. Export Data dari Database

```bash
# Export semua data
php artisan tinker --execute="echo json_encode(\App\Models\Setting::all()->toArray(), JSON_PRETTY_PRINT);" > settings.json
php artisan tinker --execute="echo json_encode(\App\Models\HeroCard::all()->toArray(), JSON_PRETTY_PRINT);" > hero_cards.json
php artisan tinker --execute="echo json_encode(\App\Models\News::all()->toArray(), JSON_PRETTY_PRINT);" > news.json
php artisan tinker --execute="echo json_encode(\App\Models\Facility::all()->toArray(), JSON_PRETTY_PRINT);" > facilities.json
php artisan tinker --execute="echo json_encode(\App\Models\Tendik::all()->toArray(), JSON_PRETTY_PRINT);" > tendik.json
```

### 2. Update CurrentDataSeeder.php

Edit file `database/seeders/CurrentDataSeeder.php` dengan data dari JSON yang di-export.

### 3. Test Seeder

```bash
php artisan db:seed --class=CurrentDataSeeder
```

## Tips

1. **Selalu backup** sebelum migrate fresh/refresh
2. **Test di local** dulu sebelum production
3. **Dokumentasikan perubahan** di seeder jika ada update data
4. **Simpan backup** di tempat aman (cloud storage, git, dll)
5. **Gunakan version control** untuk seeder file

## Seeder Lainnya

Jika ingin menggunakan seeder default (data sample):

```bash
php artisan migrate:fresh --seed
```

Ini akan menjalankan `DatabaseSeeder` yang berisi:
- AdminUserSeeder
- SettingsSeeder
- HeroCardSeeder
- SampleDataSeeder
