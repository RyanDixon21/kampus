# Cara Test Perbaikan Upload Gambar

## Test 1: Logo Kampus (Setting)
1. Login ke admin panel Filament
2. Buka menu **Pengaturan**
3. Upload logo baru
4. Simpan
5. Cek folder `storage/app/public/settings/` - seharusnya hanya ada 1 file logo
6. Upload logo baru lagi (ganti)
7. Cek folder lagi - file lama harus terhapus, hanya ada logo baru

## Test 2: Foto Tendik
1. Buka menu **Tendik**
2. Edit salah satu tendik
3. Upload foto baru
4. Simpan
5. Cek folder `storage/app/public/tendik/`
6. Ganti foto lagi
7. File lama harus terhapus

## Test 3: Hero Slides
1. Buka menu **Hero Cards**
2. Edit salah satu hero card
3. Ganti background image
4. Simpan
5. Cek folder `storage/app/public/hero-slides/`
6. File lama harus terhapus

## Test 4: Berita (Multiple Images)
1. Buka menu **Berita**
2. Edit salah satu berita
3. Ganti thumbnail
4. Hapus salah satu gambar dari gallery
5. Tambah gambar baru ke gallery
6. Simpan
7. Cek folder `storage/app/public/news/`:
   - Thumbnail lama harus terhapus
   - Gambar yang dihapus dari gallery harus terhapus
   - Gambar baru harus ada

## Test 5: Delete Record
1. Hapus salah satu berita/tendik/hero card
2. Cek folder storage terkait
3. Semua file yang terkait dengan record tersebut harus terhapus

## Verifikasi Manual
Sebelum test, catat jumlah file di folder:
```bash
# Windows PowerShell
(Get-ChildItem -Path storage\app\public\settings -Recurse -File).Count
(Get-ChildItem -Path storage\app\public\tendik -Recurse -File).Count
(Get-ChildItem -Path storage\app\public\news -Recurse -File).Count
```

Setelah test, jumlah file seharusnya tidak bertambah terus-menerus.

## Expected Result
✅ File lama terhapus otomatis saat diganti
✅ File terhapus saat record dihapus
✅ Tidak ada penumpukan file di storage
✅ Storage tetap efisien
