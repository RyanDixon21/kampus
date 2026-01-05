# Perbaikan Link Tombol Hero Card

## Masalah
Sebelumnya, field "Link Tombol" di Hero Card hanya menerima URL lengkap dengan protokol (http:// atau https://). Ini membuat tidak bisa menggunakan path internal seperti `/home`, `/news`, atau `/registration`.

## Solusi
Field "Link Tombol" sekarang mendukung dua jenis link:

### 1. Path Internal (Relative URL)
Untuk navigasi ke halaman dalam website yang sama:
- `/home` - Ke halaman home
- `/news` - Ke halaman berita
- `/registration` - Ke halaman pendaftaran
- `/facility` - Ke halaman fasilitas
- Dan path internal lainnya

### 2. URL Eksternal (Absolute URL)
Untuk link ke website luar:
- `https://example.com` - Link ke website eksternal
- `https://ubk.example.com` - Link ke sistem UBK
- `https://pmb.example.com` - Link ke sistem PMB

## Contoh Penggunaan

### Tombol Pendaftaran (Internal)
```
Teks Tombol: Daftar Sekarang
Link Tombol: /registration
```

### Tombol ke Sistem UBK (Eksternal)
```
Teks Tombol: Ikuti UBK
Link Tombol: https://ubk.sttpratama.ac.id
```

### Tombol ke Berita (Internal)
```
Teks Tombol: Lihat Berita
Link Tombol: /news
```

### Tombol ke PMB Online (Eksternal)
```
Teks Tombol: PMB Online
Link Tombol: https://pmb.sttpratama.ac.id
```

## Validasi
Sistem akan memvalidasi bahwa link harus:
- Dimulai dengan `/` untuk path internal, ATAU
- Berupa URL lengkap yang valid (http:// atau https://)

Jika format tidak sesuai, akan muncul error: "Link harus berupa path internal (contoh: /home) atau URL lengkap (contoh: https://example.com)"

## File yang Diubah
- `app/Filament/Resources/HeroCards/HeroCardResource.php`

## Testing
1. Buka admin panel → Hero Slider
2. Create/Edit hero card
3. Coba isi Link Tombol dengan:
   - `/registration` ✅ Valid
   - `/news` ✅ Valid
   - `https://example.com` ✅ Valid
   - `example.com` ❌ Invalid (harus pakai https://)
   - `home` ❌ Invalid (harus pakai /)
