# Current Data Seeder

Seeder ini berisi data produksi yang sedang digunakan saat ini di website STT Pratama Adi.

## Cara Penggunaan

### Menjalankan Seeder

Untuk menjalankan seeder ini secara terpisah, gunakan command:

```bash
php artisan db:seed --class=CurrentDataSeeder
```

### Menjalankan dengan Migrate Fresh

Jika ingin melakukan migrate fresh dan langsung seed dengan data ini:

```bash
php artisan migrate:fresh --seed --seeder=CurrentDataSeeder
```

### Menjalankan dengan Migrate Refresh

```bash
php artisan migrate:refresh --seed --seeder=CurrentDataSeeder
```

## Data yang Di-seed

Seeder ini akan mengisi data untuk:

1. **Settings** - Konfigurasi website (nama universitas, logo, kontak, dll)
2. **Hero Cards** - Slide hero section di homepage
3. **News** - Berita yang ditampilkan
4. **Facilities** - Fasilitas kampus
5. **Tendik** - Data tenaga kependidikan

## Catatan Penting

⚠️ **PERHATIAN**: Seeder ini akan **menghapus semua data** yang ada di tabel-tabel tersebut sebelum mengisi data baru.

### File yang Diperlukan

Pastikan file-file berikut ada di storage sebelum menjalankan seeder:

- `storage/app/public/settings/01KE6FMBD45PQGQTD801DSNMAQ.png` (Logo)
- `storage/app/public/settings/campus/01KE6KYF61MYMMB6Q09ZCABRDB.jpg` (Campus Image 1)
- `storage/app/public/settings/campus/01KE6KYF6811SP935M9JHB2A0K.jpg` (Campus Image 2)
- `storage/app/public/hero-slides/01KE6FVV4F2TXGM5F6VYPJ1EEN.jpg` (Hero Background)
- `storage/app/public/news/thumbnails/01KE6HB7VDJDDSYNF8M5XS3VGG.jpg` (News Thumbnail)
- `storage/app/public/news/gallery/01KE6HB7VMBZ68T61STBRG3KAA.jpg` (News Gallery)
- `storage/app/public/facilities/thumbnails/01KE6HDQ1XG9HGYN28PF0JG5JC.png` (Facility Thumbnail)
- `storage/app/public/facilities/gallery/01KE6HDQ271BEYR5YBQ2XWEH93.jpg` (Facility Gallery)
- `storage/app/public/tendik/01KE6KP830AD6ETC27SZ1QD7PP.jpg` (Tendik Photo)

### Backup Storage

Sebelum migrate fresh/refresh, backup folder storage:

```bash
# Windows
xcopy /E /I storage\app\public storage_backup

# Linux/Mac
cp -r storage/app/public storage_backup
```

Setelah migrate, restore kembali:

```bash
# Windows
xcopy /E /I storage_backup storage\app\public

# Linux/Mac
cp -r storage_backup/* storage/app/public/
```

## Update Seeder

Jika ada perubahan data dan ingin update seeder ini, jalankan command berikut untuk export data terbaru:

```bash
# Export Settings
php artisan tinker --execute="echo json_encode(\App\Models\Setting::all()->toArray(), JSON_PRETTY_PRINT);"

# Export Hero Cards
php artisan tinker --execute="echo json_encode(\App\Models\HeroCard::all()->toArray(), JSON_PRETTY_PRINT);"

# Export News
php artisan tinker --execute="echo json_encode(\App\Models\News::all()->toArray(), JSON_PRETTY_PRINT);"

# Export Facilities
php artisan tinker --execute="echo json_encode(\App\Models\Facility::all()->toArray(), JSON_PRETTY_PRINT);"

# Export Tendik
php artisan tinker --execute="echo json_encode(\App\Models\Tendik::all()->toArray(), JSON_PRETTY_PRINT);"
```

Kemudian update file `CurrentDataSeeder.php` dengan data yang baru.
