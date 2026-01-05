# Contoh Penggunaan Link di Hero Card

## Skenario 1: Tombol Pendaftaran Mahasiswa Baru
**Use Case:** Mengarahkan calon mahasiswa ke halaman pendaftaran internal

```
Judul Utama: Selamat Datang di
Sub Judul: STT Pratama Adi
Deskripsi: Wujudkan Impian Teknologimu Bersama Kami
Teks Tombol: Daftar Sekarang
Link Tombol: /registration
```

**Hasil:** Tombol akan mengarah ke `https://yourdomain.com/registration`

---

## Skenario 2: Tombol ke Sistem UBK (Ujian Berbasis Komputer)
**Use Case:** Mengarahkan peserta ujian ke sistem UBK eksternal

```
Judul Utama: Ujian Masuk
Sub Judul: Telah Dibuka
Deskripsi: Ikuti Ujian Berbasis Komputer Sekarang
Teks Tombol: Ikuti UBK
Link Tombol: https://ubk.sttpratama.ac.id
```

**Hasil:** Tombol akan mengarah ke sistem UBK eksternal

---

## Skenario 3: Tombol ke Halaman Berita
**Use Case:** Mengarahkan pengunjung untuk melihat berita terbaru

```
Judul Utama: Informasi Terkini
Sub Judul: Kampus STT Pratama Adi
Deskripsi: Dapatkan Update Berita dan Kegiatan Kampus
Teks Tombol: Lihat Berita
Link Tombol: /news
```

**Hasil:** Tombol akan mengarah ke `https://yourdomain.com/news`

---

## Skenario 4: Tombol ke PMB Online
**Use Case:** Mengarahkan ke sistem Penerimaan Mahasiswa Baru eksternal

```
Judul Utama: PMB 2025
Sub Judul: Pendaftaran Dibuka
Deskripsi: Daftar Melalui Sistem PMB Online Kami
Teks Tombol: PMB Online
Link Tombol: https://pmb.sttpratama.ac.id
```

**Hasil:** Tombol akan mengarah ke sistem PMB eksternal

---

## Skenario 5: Tombol ke Halaman Fasilitas
**Use Case:** Menampilkan fasilitas kampus

```
Judul Utama: Fasilitas Modern
Sub Judul: Untuk Pembelajaran Optimal
Deskripsi: Lihat Berbagai Fasilitas yang Kami Sediakan
Teks Tombol: Lihat Fasilitas
Link Tombol: /facility
```

**Hasil:** Tombol akan mengarah ke `https://yourdomain.com/facility`

---

## Skenario 6: Slide Tanpa Tombol
**Use Case:** Hanya menampilkan informasi tanpa call-to-action

```
Judul Utama: Selamat Datang
Sub Judul: STT Pratama Adi
Deskripsi: Sekolah Tinggi Teknologi Terdepan
Teks Tombol: (kosongkan)
Link Tombol: (kosongkan)
```

**Hasil:** Tidak ada tombol yang ditampilkan

---

## Tips Penggunaan

### ✅ Format yang Benar
- `/home` - Path internal
- `/news` - Path internal
- `/registration` - Path internal
- `/facility` - Path internal
- `https://example.com` - URL eksternal
- `https://ubk.example.com` - URL eksternal

### ❌ Format yang Salah
- `home` - Harus pakai `/` di depan
- `example.com` - Harus pakai `https://`
- `www.example.com` - Harus pakai `https://`
- `http://example.com` - Lebih baik pakai `https://`

---

## Catatan Penting

1. **Path Internal** selalu dimulai dengan `/`
2. **URL Eksternal** harus lengkap dengan protokol (`https://`)
3. Jika **Teks Tombol** kosong, tombol tidak akan ditampilkan meskipun Link Tombol diisi
4. Jika **Link Tombol** kosong, tombol tidak akan ditampilkan meskipun Teks Tombol diisi
5. Kedua field (Teks Tombol dan Link Tombol) harus diisi agar tombol muncul
