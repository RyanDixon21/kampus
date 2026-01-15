# Deployment Guide - Fix Filament 403 Forbidden

## Masalah
Halaman Filament admin menampilkan error **403 Forbidden** setelah deploy ke server.

## Penyebab
1. **Tabel `settings` belum ada** - AdminPanelProvider mencoba mengakses tabel settings yang belum di-migrate
2. **Storage belum ter-setup** - Logo dari storage tidak bisa diakses
3. **Cache belum di-clear** - Cache lama masih tersimpan

## Solusi

### 1. Di Server, Jalankan Perintah Ini:

```bash
# Clear semua cache
php artisan optimize:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan cache:clear

# Jalankan migration (termasuk tabel settings)
php artisan migrate --force

# Seed data default
php artisan db:seed --class=SettingSeeder --force
php artisan db:seed --class=AdminUserSeeder --force

# Create storage link
php artisan storage:link

# Build assets
npm install
npm run build

# Cache ulang untuk production
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan optimize
```

### 2. Login ke Filament

Setelah menjalankan perintah di atas, akses:
- URL: `https://yourdomain.com/admin`
- Email: `admin@sikademik.cloud`
- Password: `admin123`

**PENTING:** Ganti password setelah login pertama kali!

### 3. Jika Masih Error

Cek log error:
```bash
tail -f storage/logs/laravel.log
```

Cek permission:
```bash
ls -la storage/
ls -la public/
```

Fix permission jika perlu:
```bash
chmod -R 775 storage bootstrap/cache public
chown -R www-data:www-data storage bootstrap/cache public
```

## Perubahan Code

### File yang Diperbaiki:

1. **app/Providers/Filament/AdminPanelProvider.php**
   - Menambahkan error handling untuk Setting::getSettings()
   - Menambahkan pengecekan apakah tabel settings exists
   - Menambahkan fallback ke default values jika error

2. **database/migrations/2024_01_01_000000_create_settings_table.php** (BARU)
   - Migration untuk tabel settings

3. **database/seeders/SettingSeeder.php** (BARU)
   - Seeder untuk data settings default

4. **database/seeders/DatabaseSeeder.php**
   - Menambahkan SettingSeeder ke daftar seeder

## Testing

Setelah deploy, test:
1. ✅ Akses `/admin` - harus muncul halaman login
2. ✅ Login dengan kredensial admin
3. ✅ Akses dashboard Filament
4. ✅ Cek semua menu resource berfungsi

## Catatan

- Pastikan `.env` di server sudah benar (APP_URL, DB_*, dll)
- Pastikan web server (nginx/apache) sudah dikonfigurasi dengan benar
- Pastikan PHP extensions yang diperlukan sudah terinstall
