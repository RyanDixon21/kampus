# Perbaikan Seeder untuk SQLite

## Masalah
Seeder `CurrentDataSeeder` menggunakan perintah MySQL-specific yang tidak kompatibel dengan SQLite:
- `SET FOREIGN_KEY_CHECKS=0;` (MySQL)
- Error: `SQLSTATE[HY000]: General error: 1 near "SET": syntax error`

## Solusi yang Diterapkan

### 1. Foreign Key Checks Multi-Database
Mengubah perintah foreign key checks agar kompatibel dengan MySQL dan SQLite:

```php
// Sebelum
DB::statement('SET FOREIGN_KEY_CHECKS=0;');
// ... truncate tables ...
DB::statement('SET FOREIGN_KEY_CHECKS=1;');

// Sesudah
$driver = DB::getDriverName();

if ($driver === 'mysql') {
    DB::statement('SET FOREIGN_KEY_CHECKS=0;');
} elseif ($driver === 'sqlite') {
    DB::statement('PRAGMA foreign_keys = OFF;');
}
// ... truncate tables ...
if ($driver === 'mysql') {
    DB::statement('SET FOREIGN_KEY_CHECKS=1;');
} elseif ($driver === 'sqlite') {
    DB::statement('PRAGMA foreign_keys = ON;');
}
```

### 2. Foreign Key Constraint pada News
Mengubah `created_by` dari `1` menjadi `null` karena user belum tentu ada saat seeding:

```php
// Sebelum
'created_by' => 1,

// Sesudah
'created_by' => null, // Set to null since user might not exist
```

## Hasil
✅ Seeder berhasil dijalankan tanpa error
✅ Kompatibel dengan MySQL dan SQLite
✅ Data berhasil di-seed:
- Settings
- Hero Cards
- News
- Facilities
- Tendik

## Cara Menjalankan
```bash
php artisan db:seed --class=CurrentDataSeeder
```

## File yang Diubah
- `database/seeders/CurrentDataSeeder.php`
