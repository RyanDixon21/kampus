# Requirements Document

## Introduction

Website kampus untuk Sekolah Tinggi Teknologi Pratama Adi (STT Pratama Adi) yang menyediakan informasi profil universitas, sistem pendaftaran mahasiswa baru, dan computer-based test. Website ini dibangun dengan Laravel dan Filament untuk memudahkan pengelolaan konten secara dinamis melalui admin panel.

## Glossary

- **System**: Website kampus STT Pratama Adi
- **Admin**: Pengguna dengan hak akses penuh untuk mengelola konten website
- **Calon_Mahasiswa**: Pengguna yang mendaftar sebagai mahasiswa baru
- **Tendik**: Tenaga Kependidikan (staff non-dosen)
- **CBT**: Computer Based Test - sistem ujian berbasis komputer
- **Admin_Panel**: Interface Filament untuk mengelola konten website
- **Frontend**: Tampilan publik website yang dapat diakses pengunjung
- **WA_Admin**: Nomor WhatsApp admin untuk konfirmasi pendaftaran

## Requirements

### Requirement 1: University Profile Management

**User Story:** Sebagai admin, saya ingin mengelola konten profil universitas, sehingga informasi kampus selalu up-to-date dan dapat diakses pengunjung.

#### Acceptance Criteria

1. THE Admin_Panel SHALL menyediakan interface untuk mengelola logo universitas
2. THE Admin_Panel SHALL menyediakan interface untuk mengelola informasi beranda (teks, gambar, video)
3. THE Admin_Panel SHALL menyediakan interface untuk mengelola berita kampus (create, read, update, delete)
4. THE Admin_Panel SHALL menyediakan interface untuk mengelola informasi fasilitas kampus
5. THE Admin_Panel SHALL menyediakan interface untuk mengelola data Tendik (create, delete)
6. WHEN admin mengupdate konten, THE System SHALL menampilkan perubahan di Frontend secara real-time

### Requirement 2: Frontend Display

**User Story:** Sebagai pengunjung, saya ingin melihat informasi kampus dengan tampilan yang menarik dan mudah dinavigasi, sehingga saya dapat memahami profil universitas dengan baik.

#### Acceptance Criteria

1. THE Frontend SHALL menampilkan halaman beranda dengan tema warna biru sesuai logo
2. THE Frontend SHALL menampilkan logo STT Pratama Adi di seluruh halaman
3. THE Frontend SHALL menampilkan menu navigasi untuk mengakses Beranda, Berita, Fasilitas, Tendik, dan Pendaftaran
4. WHEN pengunjung mengklik menu navigasi, THE System SHALL menampilkan konten yang sesuai dalam satu halaman (single page)
5. THE Frontend SHALL menampilkan daftar berita dengan thumbnail dan excerpt
6. THE Frontend SHALL menampilkan informasi fasilitas kampus dengan gambar dan deskripsi
7. THE Frontend SHALL menampilkan daftar Tendik dengan foto dan informasi
8. THE Frontend SHALL responsive dan dapat diakses dari desktop dan mobile

### Requirement 3: Student Registration System

**User Story:** Sebagai calon mahasiswa, saya ingin mendaftar secara online, sehingga proses pendaftaran lebih mudah dan efisien.

#### Acceptance Criteria

1. THE System SHALL menyediakan form pendaftaran untuk Calon_Mahasiswa
2. WHEN Calon_Mahasiswa mengakses halaman pendaftaran, THE System SHALL menampilkan form isi data diri
3. THE System SHALL memvalidasi data yang diinput oleh Calon_Mahasiswa
4. WHEN data diri valid, THE System SHALL menyimpan data ke database
5. THE System SHALL generate nomor pendaftaran unik untuk setiap Calon_Mahasiswa
6. WHEN pendaftaran berhasil, THE System SHALL menampilkan halaman pembayaran
7. THE System SHALL menampilkan informasi biaya pendaftaran dan metode pembayaran
8. WHEN proses selesai, THE System SHALL menampilkan nomor WA_Admin untuk konfirmasi
9. THE System SHALL menyimpan status pendaftaran Calon_Mahasiswa

### Requirement 4: Computer Based Test System

**User Story:** Sebagai calon mahasiswa, saya ingin mengikuti ujian masuk secara online, sehingga proses seleksi lebih efisien.

#### Acceptance Criteria

1. THE System SHALL menyediakan modul CBT untuk ujian masuk
2. WHEN Calon_Mahasiswa login ke CBT, THE System SHALL memverifikasi nomor pendaftaran
3. THE System SHALL menampilkan soal ujian secara acak
4. THE System SHALL mencatat jawaban Calon_Mahasiswa secara real-time
5. THE System SHALL menghitung waktu ujian dan menampilkan countdown timer
6. WHEN waktu habis, THE System SHALL otomatis submit jawaban
7. THE System SHALL menghitung skor ujian
8. THE Admin_Panel SHALL menyediakan interface untuk mengelola soal ujian (create, read, update, delete)

### Requirement 5: Admin Panel Management

**User Story:** Sebagai admin, saya ingin mengelola seluruh konten website melalui interface yang mudah digunakan, sehingga saya dapat mengupdate website tanpa bantuan developer.

#### Acceptance Criteria

1. THE System SHALL menggunakan Filament sebagai Admin_Panel
2. THE Admin_Panel SHALL memerlukan autentikasi untuk akses
3. THE Admin_Panel SHALL menyediakan dashboard dengan statistik website
4. THE Admin_Panel SHALL menyediakan menu untuk mengelola Settings (logo, alamat, kontak, social media)
5. THE Admin_Panel SHALL menyediakan menu untuk mengelola Berita
6. THE Admin_Panel SHALL menyediakan menu untuk mengelola Fasilitas
7. THE Admin_Panel SHALL menyediakan menu untuk mengelola Tendik
8. THE Admin_Panel SHALL menyediakan menu untuk mengelola Pendaftaran
9. THE Admin_Panel SHALL menyediakan menu untuk mengelola CBT (soal, peserta, hasil)
10. THE Admin_Panel SHALL menyediakan menu untuk mengelola Users dan Roles

### Requirement 6: Database and Performance

**User Story:** Sebagai developer, saya ingin website memiliki struktur database yang baik dan performa yang cepat, sehingga website dapat diakses dengan lancar.

#### Acceptance Criteria

1. THE System SHALL menggunakan MySQL sebagai database
2. THE System SHALL menggunakan Laravel migrations untuk struktur database
3. THE System SHALL menggunakan Laravel Eloquent ORM untuk query database
4. THE System SHALL mengoptimalkan query database dengan eager loading
5. THE System SHALL menggunakan caching untuk konten yang sering diakses
6. THE System SHALL mengoptimalkan gambar sebelum disimpan
7. THE System SHALL memiliki loading time halaman kurang dari 3 detik

### Requirement 7: Security and Data Protection

**User Story:** Sebagai admin, saya ingin data website dan pendaftar terlindungi dengan baik, sehingga tidak ada akses tidak sah.

#### Acceptance Criteria

1. THE System SHALL menggunakan Laravel authentication untuk Admin_Panel
2. THE System SHALL mengenkripsi password pengguna
3. THE System SHALL memvalidasi semua input untuk mencegah SQL injection
4. THE System SHALL memvalidasi semua input untuk mencegah XSS attacks
5. THE System SHALL menggunakan CSRF protection untuk semua form
6. THE System SHALL membatasi akses Admin_Panel hanya untuk user dengan role admin
7. THE System SHALL menyimpan log aktivitas admin

### Requirement 8: Content Management Features

**User Story:** Sebagai admin, saya ingin fitur editor yang mudah untuk mengelola konten, sehingga saya dapat membuat konten yang menarik tanpa pengetahuan teknis.

#### Acceptance Criteria

1. THE Admin_Panel SHALL menyediakan rich text editor untuk konten berita dan fasilitas
2. THE Admin_Panel SHALL menyediakan media library untuk mengelola gambar dan file
3. THE Admin_Panel SHALL menyediakan preview konten sebelum publish
4. THE Admin_Panel SHALL menyediakan fitur draft untuk konten yang belum siap dipublikasi
5. THE Admin_Panel SHALL menyediakan fitur schedule publish untuk konten
6. WHEN admin mengupload gambar, THE System SHALL otomatis resize dan compress gambar

### Requirement 9: WhatsApp Integration

**User Story:** Sebagai calon mahasiswa, saya ingin dapat mengkonfirmasi pendaftaran melalui WhatsApp, sehingga proses komunikasi lebih mudah.

#### Acceptance Criteria

1. THE System SHALL menyimpan nomor WA_Admin di settings
2. WHEN pendaftaran selesai, THE System SHALL menampilkan nomor WA_Admin
3. THE System SHALL menampilkan template pesan untuk konfirmasi pendaftaran
4. THE System SHALL menyediakan tombol untuk membuka WhatsApp dengan pesan pre-filled
5. THE Admin_Panel SHALL menyediakan interface untuk mengupdate nomor WA_Admin

### Requirement 10: Responsive Design and Theme

**User Story:** Sebagai pengunjung, saya ingin website dapat diakses dengan baik dari berbagai perangkat, sehingga saya dapat mengakses informasi kapan saja.

#### Acceptance Criteria

1. THE Frontend SHALL menggunakan tema warna biru sesuai dengan logo STT Pratama Adi
2. THE Frontend SHALL responsive untuk desktop, tablet, dan mobile
3. THE Frontend SHALL menggunakan modern CSS framework (Tailwind CSS)
4. THE Frontend SHALL menampilkan animasi yang smooth dan tidak mengganggu
5. THE Frontend SHALL memiliki loading indicator untuk proses yang membutuhkan waktu
6. THE Frontend SHALL accessible dan memenuhi standar WCAG 2.1 Level AA
