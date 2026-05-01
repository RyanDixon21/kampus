# 📚 Panduan Seeder - Data Pendaftaran Kampus

## 🎯 Overview

Seeder ini membuat data pendaftaran sesuai permintaan klien dengan struktur:
- **2 Program Studi**: Digital Marketing dan Teknik Informatika
- **2 Jalur Pendaftaran**: Mandiri dan KIP (Kartu Indonesia Pintar)
- **3 Gelombang**: Gelombang 1, 2, dan 3 (hanya Gelombang 1 yang aktif)

---

## 🚀 Cara Menjalankan Seeder

### Opsi 1: Seeder Lengkap (RECOMMENDED)
Seeder ini akan:
- ✅ Menonaktifkan semua jalur pendaftaran lama
- ✅ Menonaktifkan semua program studi lama
- ✅ Membuat data baru sesuai permintaan

```bash
php artisan db:seed --class=CleanAndSeedCurrentData
```

### Opsi 2: Seeder Tanpa Membersihkan Data Lama
Jika ingin menambahkan data baru tanpa menonaktifkan data lama:

```bash
php artisan db:seed --class=CurrentRegistrationSeeder
```

---

## 📊 Data Yang Dibuat

### 1. Program Studi (2)

| Nama | Kode | Fakultas | Jenjang | Status |
|------|------|----------|---------|--------|
| Digital Marketing | S1-DM | Fakultas Ekonomi dan Bisnis | S1 | ✅ Aktif |
| Teknik Informatika | S1-TI | Fakultas Teknik | S1 | ✅ Aktif |

### 2. Jalur Pendaftaran (6 Total)

#### A. Jalur Mandiri

| Gelombang | Periode | Biaya | Kuota | Status |
|-----------|---------|-------|-------|--------|
| Gelombang 1 | 1 Okt 2025 - 31 Jan 2026 | Rp 350.000 | 500 | ✅ AKTIF |
| Gelombang 2 | 1 Feb 2026 - 31 Mei 2026 | Rp 350.000 | 400 | ⏳ Belum Aktif |
| Gelombang 3 | 1 Jun 2026 - 30 Sep 2026 | Rp 350.000 | 300 | ⏳ Belum Aktif |

**Pilihan Kelas Mandiri:**
- 🌅 Reguler (Pagi | Senin - Sabtu)
- 🌙 Karyawan (Malam | Senin - Sabtu)
- 🎯 Eksekutif (Pagi | Sabtu - Minggu)

#### B. Jalur KIP (Kartu Indonesia Pintar)

| Gelombang | Periode | Biaya | Kuota | Status |
|-----------|---------|-------|-------|--------|
| Gelombang 1 | 1 Okt 2025 - 31 Jan 2026 | Rp 250.000 | 200 | ✅ AKTIF |
| Gelombang 2 | 1 Feb 2026 - 31 Mei 2026 | Rp 250.000 | 150 | ⏳ Belum Aktif |
| Gelombang 3 | 1 Jun 2026 - 30 Sep 2026 | Rp 250.000 | 100 | ⏳ Belum Aktif |

**Kelas KIP:**
- 🌅 Reguler (Otomatis, tidak bisa pilih)

---

## 🎨 Tampilan Frontend

Setelah seeder dijalankan, halaman `/registration/search` akan menampilkan:

### Card 1: Mandiri (Biru 🔵)
```
┌─────────────────────────────────────┐
│         [Icon Mandiri]              │
│                                     │
│           MANDIRI                   │
│  Jalur pendaftaran mandiri untuk    │
│  calon mahasiswa baru...            │
│                                     │
│  📅 1 Okt 2025 - 31 Jan 2026       │
│  💰 Rp 350.000                      │
│  📊 Gelombang 1                     │
│                                     │
│  Pilihan Kelas:                     │
│  • Reguler (Pagi | Senin-Sabtu)    │
│  • Karyawan (Malam | Senin-Sabtu)  │
│  • Eksekutif (Pagi | Sabtu-Minggu) │
│                                     │
│  [Daftar Jalur Mandiri →]          │
└─────────────────────────────────────┘
```

### Card 2: KIP (Hijau 🟢)
```
┌─────────────────────────────────────┐
│         [Icon KIP]                  │
│                                     │
│  KARTU INDONESIA PINTAR (KIP)       │
│  Jalur pendaftaran untuk pemegang   │
│  Kartu Indonesia Pintar...          │
│                                     │
│  📅 1 Okt 2025 - 31 Jan 2026       │
│  💰 Rp 250.000                      │
│  📊 Gelombang 1                     │
│                                     │
│  Kelas:                             │
│  • Reguler (Pagi | Senin-Sabtu)    │
│  *Otomatis masuk kelas Reguler      │
│                                     │
│  [Daftar Jalur KIP →]              │
└─────────────────────────────────────┘
```

---

## 🧪 Testing Checklist

### 1. Verifikasi Database
```bash
# Cek program studi aktif
php artisan tinker
>>> App\Models\StudyProgram::where('is_active', 1)->pluck('name')
# Output: ["Digital Marketing", "Teknik Informatika"]

# Cek jalur pendaftaran aktif
>>> App\Models\RegistrationPath::where('is_active', 1)->pluck('name')
# Output: ["Mandiri", "Kartu Indonesia Pintar (KIP)"]
```

### 2. Test Frontend
- [ ] Buka: `http://localhost/registration/search`
- [ ] Harus muncul 2 card: Mandiri (biru) dan KIP (hijau)
- [ ] Klik card Mandiri → harus masuk form dengan pilihan kelas
- [ ] Klik card KIP → harus masuk form tanpa pilihan kelas

### 3. Test Alur Pendaftaran Mandiri
- [ ] Pilih jalur Mandiri
- [ ] Isi form pendaftaran
- [ ] Pilih salah satu kelas (Reguler/Karyawan/Eksekutif)
- [ ] Pilih program studi (Digital Marketing atau Teknik Informatika)
- [ ] Lanjut ke konfirmasi
- [ ] Pastikan "Kelas Yang Dipilih" muncul dengan benar
- [ ] Lanjut ke pembayaran
- [ ] Selesaikan pendaftaran

### 4. Test Alur Pendaftaran KIP
- [ ] Pilih jalur KIP
- [ ] Isi form pendaftaran (tidak ada pilihan kelas)
- [ ] Pilih program studi (Digital Marketing atau Teknik Informatika)
- [ ] Lanjut ke konfirmasi
- [ ] Pastikan otomatis "Mandiri Reguler"
- [ ] Lanjut ke pembayaran
- [ ] Selesaikan pendaftaran

### 5. Test Filament Admin
- [ ] Login ke Filament admin
- [ ] Menu: Pendaftaran → Jalur Pendaftaran
- [ ] Harus ada 6 jalur (2 aktif, 4 belum aktif)
- [ ] Menu: Akademik → Program Studi
- [ ] Harus ada 2 program studi aktif
- [ ] Menu: Pendaftaran → Data Pendaftaran
- [ ] Lihat detail pendaftaran, pastikan class_type tersimpan

---

## 🔧 Troubleshooting

### Masalah: Masih muncul jalur lama
**Solusi:**
```bash
php artisan db:seed --class=CleanAndSeedCurrentData
```

### Masalah: Card tidak muncul di frontend
**Cek:**
1. Apakah jalur `is_active = true`?
2. Apakah nama jalur mengandung "Mandiri" atau "KIP"?
3. Clear cache: `php artisan cache:clear`

### Masalah: Program studi tidak muncul di form
**Cek:**
1. Apakah program studi `is_active = true`?
2. Apakah program studi terhubung dengan jalur pendaftaran?
```bash
php artisan tinker
>>> $path = App\Models\RegistrationPath::where('slug', 'mandiri-gelombang-1')->first();
>>> $path->studyPrograms()->pluck('name');
# Output: ["Digital Marketing", "Teknik Informatika"]
```

---

## 📝 Mengubah Data

### Mengubah Biaya Pendaftaran
Edit file `database/seeders/CleanAndSeedCurrentData.php`:
```php
'registration_fee' => 350000, // Ubah nilai ini
```

Lalu jalankan ulang:
```bash
php artisan db:seed --class=CleanAndSeedCurrentData
```

### Mengaktifkan Gelombang 2
Edit file `database/seeders/CleanAndSeedCurrentData.php`:
```php
// Cari bagian Gelombang 2
'is_active' => true, // Ubah dari false ke true
```

Lalu jalankan ulang:
```bash
php artisan db:seed --class=CleanAndSeedCurrentData
```

### Menambah Program Studi Baru
Edit file `database/seeders/CleanAndSeedCurrentData.php`:
```php
$programs = [
    // ... program studi yang sudah ada
    [
        'name' => 'Sistem Informasi',
        'code' => 'S1-SI',
        'faculty' => 'Fakultas Teknik',
        'degree_level' => 'S1',
        'description' => 'Program studi Sistem Informasi...',
        'is_active' => true,
    ],
];
```

---

## 📂 File Seeder

| File | Deskripsi |
|------|-----------|
| `CleanAndSeedCurrentData.php` | ✅ RECOMMENDED - Bersihkan data lama + buat data baru |
| `CurrentRegistrationSeeder.php` | Buat data baru tanpa hapus data lama |
| `README_CURRENT_REGISTRATION.md` | Dokumentasi lengkap |

---

## 🎓 Struktur Kelas

### Mandiri
- **Reguler**: Kuliah pagi (Senin - Sabtu)
- **Karyawan**: Kuliah malam (Senin - Sabtu)
- **Eksekutif**: Kuliah pagi (Sabtu - Minggu)

### KIP
- **Reguler**: Kuliah pagi (Senin - Sabtu) - Otomatis

---

## 💡 Tips

1. **Gunakan CleanAndSeedCurrentData** untuk hasil yang bersih
2. **Backup database** sebelum menjalankan seeder di production
3. **Test di local** terlebih dahulu sebelum deploy
4. **Dokumentasikan perubahan** jika mengubah data seeder

---

## 📞 Support

Jika ada pertanyaan atau masalah:
1. Cek dokumentasi ini terlebih dahulu
2. Cek file README di folder seeders
3. Hubungi tim development

---

**Last Updated**: 30 April 2026
**Version**: 1.0.0
