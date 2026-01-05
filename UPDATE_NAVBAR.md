# Update Navbar Header

## Perubahan yang Dilakukan

### 1. Penambahan Tekstur Background
Navbar sekarang memiliki tekstur dekoratif yang mirip dengan background home:
- **Dot Pattern**: Pola titik-titik halus di seluruh navbar
- **Decorative Shapes**: Lingkaran dan kotak dekoratif dengan opacity rendah
- **Opacity**: Semua tekstur menggunakan opacity 10-20% agar tidak mengganggu

### 2. Button "Pendaftaran" → Dropdown "Akademik"
Button pendaftaran diganti dengan dropdown menu "Akademik" yang berisi:

#### Menu Items:
1. **Pendaftaran** 
   - Icon: User Plus
   - Link: `/registration` (sudah terhubung)
   
2. **KRS** (Kartu Rencana Studi)
   - Icon: Document
   - Link: `#` (placeholder, siap untuk diisi)
   
3. **UBK** (Ujian Berbasis Komputer)
   - Icon: Clipboard
   - Link: `#` (placeholder, siap untuk diisi)

### 3. Fitur Dropdown

#### Desktop:
- Klik button "Akademik" untuk membuka dropdown
- Klik di luar dropdown untuk menutup (click away)
- Animasi smooth saat buka/tutup
- Hover effect pada setiap menu item

#### Mobile:
- Dropdown terintegrasi dalam mobile menu
- Klik untuk expand/collapse
- Icon berputar saat dibuka
- Menu items dengan icon dan spacing yang baik

### 4. Styling

#### Karakteristik:
- ✅ Tidak ada efek glass/glassmorphism
- ✅ Tidak ada gradasi
- ✅ Simpel dan clean
- ✅ Tekstur halus seperti background home
- ✅ Konsisten dengan design system

#### Colors:
- Background navbar: `primary-800/95` dengan backdrop blur
- Dropdown background: `white` dengan shadow
- Hover state: `blue-50` untuk dropdown items
- Border: `border-gray-200` untuk dropdown

### 5. Responsiveness

#### Desktop (md+):
- Dropdown muncul di kanan bawah button
- Width: 224px (w-56)
- Shadow dan border untuk depth

#### Mobile:
- Dropdown expand di dalam mobile menu
- Full width dengan padding left
- Smooth transition

## Cara Menambahkan Link

### Untuk KRS:
Ganti `href="#"` pada menu KRS dengan link yang sesuai:
```blade
<a href="{{ route('krs.index') }}" 
   class="flex items-center px-4 py-3 text-gray-700 hover:bg-blue-50 hover:text-primary-700 transition-colors duration-200">
```

### Untuk UBK:
Ganti `href="#"` pada menu UBK dengan link yang sesuai:
```blade
<a href="{{ route('ubk.index') }}" 
   class="flex items-center px-4 py-3 text-gray-700 hover:bg-blue-50 hover:text-primary-700 transition-colors duration-200">
```

Atau jika menggunakan URL eksternal:
```blade
<a href="https://ubk.sttpratama.ac.id" 
   target="_blank"
   class="flex items-center px-4 py-3 text-gray-700 hover:bg-blue-50 hover:text-primary-700 transition-colors duration-200">
```

## File yang Diubah
- `resources/views/layouts/app.blade.php`

## Testing Checklist

### Desktop:
- [ ] Navbar menampilkan tekstur background
- [ ] Button "Akademik" terlihat dengan baik
- [ ] Klik button membuka dropdown
- [ ] Dropdown menampilkan 3 menu items dengan icon
- [ ] Hover pada menu items berfungsi
- [ ] Klik di luar dropdown menutup dropdown
- [ ] Link Pendaftaran berfungsi

### Mobile:
- [ ] Hamburger menu berfungsi
- [ ] Mobile menu menampilkan tekstur
- [ ] Button "Akademik" terlihat
- [ ] Klik button expand dropdown
- [ ] Icon berputar saat expand
- [ ] 3 menu items terlihat dengan icon
- [ ] Link Pendaftaran berfungsi

## Preview Struktur

```
Navbar
├── Logo + Nama Kampus
├── Menu Links (Desktop)
│   ├── Beranda
│   ├── Berita
│   ├── Fasilitas
│   ├── Tendik
│   └── Akademik (Dropdown) ⬇️
│       ├── 📝 Pendaftaran
│       ├── 📄 KRS
│       └── 📋 UBK
└── Hamburger (Mobile)
    └── Mobile Menu
        ├── Beranda
        ├── Berita
        ├── Fasilitas
        ├── Tendik
        └── Akademik (Expandable) ⬇️
            ├── 📝 Pendaftaran
            ├── 📄 KRS
            └── 📋 UBK
```

## Catatan Teknis

### Alpine.js State:
- `akademikDropdown`: Boolean untuk toggle dropdown
- `mobileMenuOpen`: Boolean untuk mobile menu
- `activeSection`: String untuk active navigation item

### Transitions:
- Dropdown: 200ms ease-out (enter), 150ms ease-in (leave)
- Mobile menu: 200ms ease-out (enter), 150ms ease-in (leave)
- Hover effects: 200ms duration

### Z-Index Layers:
- Navbar: `z-50`
- Dropdown: `z-10` (relative to navbar)
- Background textures: `z-0` (behind content)
