# Perbaikan Kolom Images di Tabel News dan Facilities

## Masalah
Error saat membuat berita baru:
```
SQLSTATE[HY000]: General error: 1 table news has no column named images
```

## Penyebab
Tabel `news` dan `facilities` tidak memiliki kolom `images` untuk menyimpan multiple images (gallery), padahal di Filament Resource sudah ada field untuk upload multiple images.

## Solusi
Menambahkan kolom `images` dengan tipe `json` ke kedua tabel:

### 1. Tabel News
- Migration: `2026_01_05_073333_add_images_to_news_table.php`
- Kolom: `images` (json, nullable)
- Posisi: Setelah kolom `thumbnail`

### 2. Tabel Facilities
- Migration: `2026_01_05_073432_add_images_to_facilities_table.php`
- Kolom: `images` (json, nullable)
- Posisi: Setelah kolom `image`

## Struktur Kolom

### News Table
```
- id
- title
- slug
- category
- content
- thumbnail (single image)
- images (multiple images - JSON array) ← BARU
- status
- published_at
- created_by
- created_at
- updated_at
```

### Facilities Table
```
- id
- name
- slug
- description
- image (single image)
- images (multiple images - JSON array) ← BARU
- status
- published_at
- order
- is_active
- created_at
- updated_at
```

## Cara Kerja

### Di Model
Kolom `images` sudah di-cast sebagai `array` di model:
```php
protected $casts = [
    'images' => 'array',
];
```

### Di Filament Resource
Field upload multiple images:
```php
FileUpload::make('images')
    ->label('Gambar Tambahan')
    ->image()
    ->multiple()
    ->directory('news/gallery') // atau 'facilities/gallery'
    ->disk('public')
    ->visibility('public')
```

### Di Database
Data disimpan sebagai JSON array:
```json
["news/gallery/image1.jpg", "news/gallery/image2.jpg", "news/gallery/image3.jpg"]
```

### Di Observer
Observer akan otomatis menghapus file yang dihapus dari array:
```php
// Membandingkan array lama vs baru
$removedImages = array_diff($oldImages, $newImages);

// Hapus file yang dihapus
foreach ($removedImages as $image) {
    Storage::disk('public')->delete($image);
}
```

## Testing
1. Buka admin panel → Berita → Create
2. Upload thumbnail
3. Upload multiple images di "Gambar Tambahan"
4. Simpan
5. ✅ Berita berhasil dibuat tanpa error
6. Edit berita, hapus salah satu gambar
7. ✅ File terhapus dari storage

## Rollback (Jika Diperlukan)
Jika perlu rollback migration:
```bash
php artisan migrate:rollback --step=2
```

Ini akan menghapus kolom `images` dari kedua tabel.
