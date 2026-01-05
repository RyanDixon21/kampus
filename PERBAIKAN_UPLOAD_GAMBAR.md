# Perbaikan Sistem Upload Gambar

## Masalah
Sebelumnya, ketika mengganti gambar (misalnya logo kampus), sistem tidak menghapus file lama dan membuat file baru. Hal ini menyebabkan:
- Penumpukan file yang tidak terpakai di storage
- Pemborosan resource server
- Storage yang membengkak seiring waktu

## Solusi
Dibuat sistem Observer untuk setiap model yang menangani upload file. Observer ini akan:
1. **Menghapus file lama** ketika file baru diupload (saat update)
2. **Menghapus semua file terkait** ketika record dihapus (saat delete)

## File yang Dibuat

### 1. Observers
- `app/Observers/SettingObserver.php` - Menangani logo dan campus_images
- `app/Observers/TendikObserver.php` - Menangani foto tendik
- `app/Observers/HeroCardObserver.php` - Menangani background image hero cards
- `app/Observers/FacilityObserver.php` - Menangani gambar fasilitas (thumbnail + gallery)
- `app/Observers/NewsObserver.php` - Menangani gambar berita (thumbnail + gallery)

### 2. AppServiceProvider
File `app/Providers/AppServiceProvider.php` diupdate untuk mendaftarkan semua observers.

## Cara Kerja

### Single File Upload (Logo, Thumbnail, dll)
```php
// Ketika user mengganti logo:
// 1. Observer mendeteksi perubahan pada field 'logo'
// 2. Mengambil path file lama dari database
// 3. Menghapus file lama dari storage
// 4. File baru disimpan (handled by Filament)
```

### Multiple Files Upload (Gallery, Campus Images)
```php
// Ketika user mengganti/menghapus gambar dari gallery:
// 1. Observer membandingkan array lama vs array baru
// 2. Mencari gambar yang dihapus (ada di array lama, tidak ada di array baru)
// 3. Menghapus file-file yang dihapus dari storage
// 4. File baru tetap tersimpan
```

## Model yang Tercover
✅ Setting (logo, campus_images)
✅ Tendik (photo)
✅ HeroCard (background_image)
✅ Facility (image, images)
✅ News (thumbnail, images)

## Testing
Untuk memastikan sistem bekerja:
1. Upload gambar baru
2. Ganti dengan gambar lain
3. Cek folder `storage/app/public/` - file lama harus terhapus
4. Hapus record - semua file terkait harus terhapus

## Catatan Penting
- Observer hanya menghapus file jika file tersebut benar-benar ada di storage
- Menggunakan `Storage::disk('public')` sesuai konfigurasi Filament
- Aman untuk multiple files (array) dan single file
- Tidak akan error jika file sudah tidak ada
