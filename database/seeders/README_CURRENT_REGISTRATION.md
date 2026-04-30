# Current Registration Seeder

## 📋 Deskripsi

Seeder ini berisi data pendaftaran saat ini sesuai permintaan klien dengan struktur:

### 🎓 Program Studi (2)
1. **Digital Marketing** (S1)
   - Fakultas: Ekonomi dan Bisnis
   - Kode: S1-DM
   - Fokus: Pemasaran digital, social media marketing, SEO, content marketing

2. **Teknik Informatika** (S1)
   - Fakultas: Teknik
   - Kode: S1-TI
   - Fokus: Pemrograman, software development, sistem informasi, database

### 🎯 Jalur Pendaftaran (2 Jalur × 3 Gelombang = 6 Total)

#### 1. Jalur Mandiri
- **Biaya Pendaftaran**: Rp 350.000
- **Pilihan Kelas**:
  - Reguler (Pagi | Senin - Sabtu)
  - Karyawan (Malam | Senin - Sabtu)
  - Eksekutif (Pagi | Sabtu - Minggu)
- **Kuota**:
  - Gelombang 1: 500 orang
  - Gelombang 2: 400 orang
  - Gelombang 3: 300 orang

#### 2. Jalur KIP (Kartu Indonesia Pintar)
- **Biaya Pendaftaran**: Rp 250.000 (lebih murah)
- **Kelas**: Otomatis Reguler (Pagi | Senin - Sabtu)
- **Kuota**:
  - Gelombang 1: 200 orang
  - Gelombang 2: 150 orang
  - Gelombang 3: 100 orang
- **Persyaratan Tambahan**: Kartu Indonesia Pintar, SKTM

### 📅 Masa Pendaftaran

| Gelombang | Periode | Status |
|-----------|---------|--------|
| Gelombang 1 | 1 Oktober 2025 - 31 Januari 2026 | ✅ AKTIF |
| Gelombang 2 | 1 Februari 2026 - 31 Mei 2026 | ⏳ Belum Aktif |
| Gelombang 3 | 1 Juni 2026 - 30 September 2026 | ⏳ Belum Aktif |

## 🚀 Cara Menjalankan

### Opsi 1: Jalankan Seeder Ini Saja
```bash
php artisan db:seed --class=CurrentRegistrationSeeder
```

### Opsi 2: Tambahkan ke DatabaseSeeder
Edit file `database/seeders/DatabaseSeeder.php`:

```php
public function run(): void
{
    $this->call([
        // ... seeder lain
        CurrentRegistrationSeeder::class,
    ]);
}
```

Lalu jalankan:
```bash
php artisan db:seed
```

### Opsi 3: Fresh Migration + Seeder (HATI-HATI: Hapus semua data)
```bash
php artisan migrate:fresh --seed
```

## 📝 Catatan Penting

1. **Gelombang 1 Aktif**: Hanya Gelombang 1 yang `is_active = true`, gelombang lainnya belum aktif
2. **Data dari Database**: Semua data jalur dan program studi diambil dari database, tidak hardcode
3. **Sync Programs**: Setiap jalur pendaftaran otomatis terhubung dengan kedua program studi
4. **UpdateOrCreate**: Menggunakan `updateOrCreate` untuk menghindari duplikasi data

## 🔄 Update Data

Jika ingin mengubah data (biaya, tanggal, kuota, dll):
1. Edit file `CurrentRegistrationSeeder.php`
2. Jalankan ulang seeder:
   ```bash
   php artisan db:seed --class=CurrentRegistrationSeeder
   ```

## 🗑️ Reset Data

Jika ingin menghapus data dan mulai dari awal:

```bash
# Hapus semua data registration paths
php artisan tinker
>>> App\Models\RegistrationPath::truncate();
>>> App\Models\StudyProgram::truncate();
>>> exit

# Jalankan ulang seeder
php artisan db:seed --class=CurrentRegistrationSeeder
```

## 📊 Struktur Data

### Registration Paths
- `name`: Nama jalur (Mandiri / Kartu Indonesia Pintar)
- `slug`: URL-friendly identifier
- `description`: Deskripsi jalur
- `registration_fee`: Biaya pendaftaran
- `start_date`: Tanggal mulai pendaftaran
- `end_date`: Tanggal akhir pendaftaran
- `is_active`: Status aktif/tidak (hanya Gelombang 1 yang aktif)
- `quota`: Kuota peserta
- `degree_level`: Jenjang (S1)
- `wave`: Gelombang (1, 2, atau 3)
- `period`: Periode akademik (2025/2026)
- `requirements`: Persyaratan pendaftaran (JSON)
- `system_type`: Tipe sistem (reguler)
- `payment_note`: Catatan pembayaran
- `payment_items`: Detail biaya (JSON)

### Study Programs
- `name`: Nama program studi
- `code`: Kode program studi
- `faculty`: Fakultas
- `degree_level`: Jenjang (S1)
- `description`: Deskripsi program studi
- `is_active`: Status aktif

## 🎨 Tampilan Frontend

Setelah seeder dijalankan, halaman pendaftaran akan menampilkan:

### Card Mandiri (Biru)
- Nama: "Mandiri"
- Biaya: Rp 350.000
- Periode: 1 Oktober 2025 - 31 Januari 2026
- Pilihan Kelas: Reguler, Karyawan, Eksekutif

### Card KIP (Hijau)
- Nama: "Kartu Indonesia Pintar (KIP)"
- Biaya: Rp 250.000
- Periode: 1 Oktober 2025 - 31 Januari 2026
- Kelas: Otomatis Reguler

## 🔍 Verifikasi Data

Setelah menjalankan seeder, verifikasi di:

1. **Database**:
   ```sql
   SELECT * FROM registration_paths WHERE is_active = 1;
   SELECT * FROM study_programs WHERE is_active = 1;
   ```

2. **Filament Admin Panel**:
   - Menu: Pendaftaran → Jalur Pendaftaran
   - Menu: Akademik → Program Studi

3. **Frontend**:
   - Buka: `/registration/search`
   - Harus muncul 2 card: Mandiri dan KIP

## 📞 Support

Jika ada pertanyaan atau masalah, hubungi tim development.
