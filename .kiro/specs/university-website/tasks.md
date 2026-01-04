# Implementation Plan: University Website

## Overview

Website kampus STT Pratama Adi akan dibangun menggunakan Laravel 11 dan Filament 3. Implementation akan dilakukan secara incremental, dimulai dari setup project, database structure, models, admin panel dengan banyak CRUD, frontend single page, dan kerangka dasar CBT. Setiap task membangun dari task sebelumnya dan fokus pada implementasi kode yang dapat langsung dijalankan.

## Tasks
  
- [x] 1. Setup Laravel Project dan Dependencies
  - Install Laravel 11 dengan composer
  - Install Filament 3 dan konfigurasi admin panel
  - Install dependencies: Intervention Image, Pest PHP
  - Setup database connection untuk MySQL di .env
  - Jalankan php artisan storage:link untuk file storage
  - _Requirements: 5.1, 6.1_

- [x] 2. Create Database Migrations
  - [x] 2.1 Create settings table migration
    - Buat migration untuk tabel settings (key-value pairs)
    - _Requirements: 1.1, 5.4, 9.1_
  
  - [x] 2.2 Create users table migration (jika belum ada)
    - Tambahkan kolom role untuk role-based access
    - _Requirements: 5.2, 7.1, 7.6_
  
  - [x] 2.3 Create news table migration
    - Kolom: title, slug, content, thumbnail, status, published_at, created_by
    - _Requirements: 1.3, 8.3, 8.4, 8.5_
  
  - [x] 2.4 Create facilities table migration
    - Kolom: name, description, image, order, is_active
    - _Requirements: 1.4_
  
  - [x] 2.5 Create tendik table migration
    - Kolom: name, position, photo, email, phone, is_active
    - _Requirements: 1.5_
  
  - [x] 2.6 Create registrations table migration
    - Kolom: registration_number, name, email, phone, address, status, payment_amount, payment_status, payment_date, cbt_score, cbt_completed_at
    - _Requirements: 3.4, 3.5, 3.9_
  
  - [x] 2.7 Create cbt_questions table migration (kerangka dasar)
    - Kolom: question, options (json), category, difficulty, is_active
    - _Requirements: 4.1, 4.8_
  
  - [x] 2.8 Create cbt_results table migration (kerangka dasar)
    - Kolom: registration_id, total_questions, correct_answers, score, started_at, completed_at
    - _Requirements: 4.7_

- [x] 3. Create Eloquent Models
  - [x] 3.1 Create Setting model
    - Implement static methods: get(), set(), getSettings()
    - Implement cache integration
    - _Requirements: 1.1, 6.5_
  
  - [x] 3.2 Create News model
    - Implement published() scope
    - Implement author relationship
    - Auto-generate slug on create
    - _Requirements: 1.3, 8.4_
  
  - [x] 3.3 Create Facility model
    - Implement active() scope
    - Implement ordering
    - _Requirements: 1.4_
  
  - [x] 3.4 Create Tendik model
    - Implement active() scope
    - _Requirements: 1.5_
  
  - [x] 3.5 Create Registration model
    - Implement pending() dan paid() scopes
    - Implement cbtResult relationship
    - _Requirements: 3.4, 3.5, 3.9_
  
  - [x] 3.6 Create CBTQuestion model (kerangka dasar)
    - Implement active() scope
    - Cast options sebagai array
    - _Requirements: 4.1, 4.3_

- [x] 4. Create Service Classes
  - [x] 4.1 Create RegistrationService
    - Implement register() method dengan transaction
    - Implement generateRegistrationNumber() method
    - Implement generateWhatsAppMessage() method
    - _Requirements: 3.4, 3.5, 9.3_
  
  - [ ]* 4.2 Write property test for RegistrationService
    - **Property 1: Data Persistence Round Trip**
    - **Property 2: Registration Number Uniqueness**
    - **Validates: Requirements 3.4, 3.5**
  
  - [x] 4.3 Create ImageService
    - Implement optimize() method untuk resize dan compress
    - Generate thumbnails dengan berbagai ukuran
    - _Requirements: 6.6, 8.6_
  
  - [ ]* 4.4 Write property test for ImageService
    - **Property 11: Image Optimization**
    - **Validates: Requirements 6.6, 8.6**
  
  - [x] 4.5 Create CBTService (kerangka dasar)
    - Implement getRandomQuestions() method
    - Implement calculateScore() method
    - Implement saveResult() method
    - _Requirements: 4.3, 4.7_

- [x] 5. Checkpoint - Ensure migrations and models work
  - Run migrations dan verify database structure
  - Test model relationships dengan tinker
  - Tanyakan user jika ada pertanyaan

- [x] 6. Create Filament Resources - Settings
  - [x] 6.1 Create SettingResource
    - Form dengan sections: Identitas Kampus, Social Media, WhatsApp Admin
    - Fields: university_name, logo (FileUpload), address, phone, email, facebook_url, instagram_url, youtube_url, wa_admin
    - Implement custom page untuk single record editing
    - _Requirements: 1.1, 5.4, 9.1, 9.5_
  
  - [ ]* 6.2 Write unit tests for Settings CRUD
    - Test create, read, update settings
    - Test cache invalidation
    - _Requirements: 1.1, 6.5_

- [x] 7. Create Filament Resources - News
  - [x] 7.1 Create NewsResource
    - Form: title, thumbnail (FileUpload), content (RichEditor), status (Select), published_at (DateTimePicker)
    - Table: thumbnail (ImageColumn), title, status (BadgeColumn), published_at
    - Filters: status
    - _Requirements: 1.3, 5.5, 8.1, 8.3, 8.4, 8.5_
  
  - [ ]* 7.2 Write property test for News
    - **Property 14: Draft Content Exclusion**
    - **Validates: Requirements 8.4, 8.5**

- [x] 8. Create Filament Resources - Facilities
  - [x] 8.1 Create FacilityResource
    - Form: name, description (Textarea), image (FileUpload), order (TextInput), is_active (Toggle)
    - Table: image (ImageColumn), name, order, is_active (IconColumn)
    - Implement reordering functionality
    - _Requirements: 1.4, 5.6_
  
  - [ ]* 8.2 Write unit tests for Facilities CRUD
    - Test create, read, update, delete
    - Test ordering
    - _Requirements: 1.4_

- [x] 9. Create Filament Resources - Tendik
  - [x] 9.1 Create TendikResource
    - Form: name, position, photo (FileUpload), email, phone, is_active (Toggle)
    - Table: photo (ImageColumn), name, position, email, phone, is_active (IconColumn)
    - _Requirements: 1.5, 5.7_
  
  - [ ]* 9.2 Write unit tests for Tendik CRUD
    - Test create and delete operations
    - _Requirements: 1.5_

- [x] 10. Create Filament Resources - Registrations
  - [x] 10.1 Create RegistrationResource
    - Table: registration_number, name, email, status (BadgeColumn), created_at
    - Filters: status
    - Infolist untuk view detail: Data Diri section dan Status section
    - Disable create dan edit (hanya view dan delete)
    - _Requirements: 3.9, 5.8_
  
  - [ ]* 10.2 Write unit tests for Registration viewing
    - Test viewing registration details
    - Test filtering by status
    - _Requirements: 3.9, 5.8_

- [x] 11. Create Filament Resources - CBT Questions (kerangka dasar)
  - [x] 11.1 Create CBTQuestionResource
    - Form: question (Textarea), options (Repeater dengan text dan is_correct checkbox), category (Select), is_active (Toggle)
    - Table: question (limit text), category, is_active (IconColumn)
    - _Requirements: 4.8, 5.9_
  
  - [ ]* 11.2 Write unit tests for CBT Questions CRUD
    - Test create, read, update, delete
    - _Requirements: 4.8_

- [x] 12. Checkpoint - Ensure all Filament resources work
  - Test semua CRUD operations di admin panel
  - Verify file uploads berfungsi
  - Tanyakan user jika ada pertanyaan

- [x] 13. Create Frontend Controllers
  - [x] 13.1 Create HomeController
    - Implement index() method
    - Load settings, latest news, facilities, tendik dengan eager loading
    - _Requirements: 2.1, 2.2, 2.3, 6.4_
  
  - [ ]* 13.2 Write property test for HomeController
    - **Property 9: Query Optimization with Eager Loading**
    - **Validates: Requirements 6.4**
  
  - [x] 13.3 Create RegistrationController
    - Implement create() untuk form pendaftaran
    - Implement store() dengan validation
    - Implement payment() untuk halaman pembayaran
    - Implement complete() untuk halaman konfirmasi dengan WhatsApp
    - _Requirements: 3.1, 3.2, 3.3, 3.6, 3.7, 3.8_
  
  - [ ]* 13.4 Write property test for RegistrationController
    - **Property 3: Input Validation Rejection**
    - **Property 15: WhatsApp Message Generation**
    - **Validates: Requirements 3.3, 9.3**
  
  - [x] 13.5 Create CBTController (kerangka dasar)
    - Implement login() untuk form login CBT
    - Implement authenticate() untuk verifikasi nomor pendaftaran
    - Implement start() untuk halaman ujian
    - Implement submit() untuk submit jawaban
    - _Requirements: 4.1, 4.2, 4.3, 4.4, 4.6, 4.7_

- [-] 14. Create Form Request Validators
  - [x] 14.1 Create RegistrationRequest
    - Validation rules: name (required), email (required, email), phone (required, regex Indonesian format), address (required)
    - Custom error messages dalam Bahasa Indonesia
    - _Requirements: 3.3, 7.3, 7.4_
  
  - [ ]* 14.2 Write property test for validation
    - **Property 3: Input Validation Rejection**
    - **Validates: Requirements 3.3**

- [x] 15. Create Frontend Views - Layout
  - [x] 15.1 Create app.blade.php layout
    - Setup Tailwind CSS dengan tema biru
    - Include logo STT Pratama Adi
    - Create navigation menu (Beranda, Berita, Fasilitas, Tendik, Pendaftaran)
    - Implement smooth scroll untuk single page navigation
    - Responsive design untuk mobile dan desktop
    - _Requirements: 2.1, 2.2, 2.3, 2.4, 2.8, 10.1, 10.2, 10.3_
  
  - [ ]* 15.2 Write browser tests for responsive design
    - Test navigation di berbagai screen sizes
    - _Requirements: 2.8, 10.2_

- [x] 16. Create Frontend Views - Home Page
  - [x] 16.1 Create home.blade.php (single page)
    - Section Beranda dengan hero image dan informasi kampus
    - Section Berita dengan grid layout dan thumbnails
    - Section Fasilitas dengan gambar dan deskripsi
    - Section Tendik dengan foto dan informasi
    - Implement smooth animations
    - Loading indicators untuk konten dinamis
    - _Requirements: 2.1, 2.4, 2.5, 2.6, 2.7, 10.4, 10.5_
  
  - [ ]* 16.2 Write unit tests for home page rendering
    - Test data passing ke view
    - _Requirements: 2.1_

- [-] 17. Create Frontend Views - Registration
  - [x] 17.1 Create registration/create.blade.php
    - Form dengan fields: name, email, phone, address
    - Client-side validation
    - Error message display
    - _Requirements: 3.1, 3.2, 3.3_
  
  - [x] 17.2 Create registration/payment.blade.php
    - Display nomor pendaftaran
    - Display informasi biaya dan metode pembayaran
    - Button untuk lanjut ke konfirmasi
    - _Requirements: 3.6, 3.7_
  
  - [x] 17.3 Create registration/complete.blade.php
    - Display nomor pendaftaran dan status
    - Display nomor WhatsApp admin
    - Button untuk buka WhatsApp dengan pesan pre-filled
    - Template pesan konfirmasi
    - _Requirements: 3.8, 9.2, 9.3, 9.4_
  
  - [ ]* 17.4 Write integration tests for registration flow
    - Test complete flow dari form sampai WhatsApp
    - _Requirements: 3.1, 3.2, 3.3, 3.6, 3.7, 3.8_

- [x] 18. Create Frontend Views - CBT (kerangka dasar)
  - [x] 18.1 Create cbt/login.blade.php
    - Form login dengan nomor pendaftaran
    - _Requirements: 4.2_
  
  - [x] 18.2 Create cbt/exam.blade.php (kerangka dasar)
    - Display soal dengan pilihan jawaban
    - Countdown timer
    - Navigation antar soal
    - Auto-submit ketika waktu habis
    - _Requirements: 4.3, 4.4, 4.5, 4.6_
  
  - [x] 18.3 Create cbt/result.blade.php (kerangka dasar)
    - Display skor ujian
    - _Requirements: 4.7_

- [x] 19. Implement Security Features
  - [x] 19.1 Setup authentication untuk admin panel
    - Configure Filament authentication
    - Create admin user seeder
    - _Requirements: 5.2, 7.1_
  
  - [ ]* 19.2 Write property test for authentication
    - **Property 8: Admin Authentication Required**
    - **Property 12: Password Encryption**
    - **Validates: Requirements 5.2, 7.2**
  
  - [x] 19.3 Implement role-based access control
    - Middleware untuk admin panel
    - Policy untuk resources
    - _Requirements: 7.6_
  
  - [ ]* 19.4 Write property test for RBAC
    - **Property 13: Role-Based Access Control**
    - **Validates: Requirements 7.6**
  
  - [x] 19.5 Implement CSRF protection
    - Verify CSRF tokens di semua forms
    - _Requirements: 7.5_
  
  - [x] 19.6 Implement input sanitization
    - XSS protection di form requests
    - SQL injection protection (sudah built-in di Eloquent)
    - _Requirements: 7.3, 7.4_

- [x] 20. Implement Caching Strategy
  - [x] 20.1 Implement cache untuk Settings
    - Cache settings dengan TTL 1 hour
    - Cache invalidation saat update
    - _Requirements: 6.5_
  
  - [ ]* 20.2 Write property test for caching
    - **Property 10: Content Caching and Updates**
    - **Validates: Requirements 1.6, 6.5**

- [x] 21. Setup Routes
  - [x] 21.1 Define web routes
    - Route untuk home page
    - Routes untuk registration flow
    - Routes untuk CBT (kerangka dasar)
    - _Requirements: 2.3, 3.1, 4.1_
  
  - [x] 21.2 Configure Filament routes
    - Admin panel di /admin
    - _Requirements: 5.1_

- [x] 22. Create Database Seeders
  - [x] 22.1 Create SettingsSeeder
    - Seed default settings (university name, logo placeholder, contact info, WA admin)
    - _Requirements: 1.1, 9.1_
  
  - [x] 22.2 Create AdminUserSeeder
    - Create default admin user
    - _Requirements: 5.2_
  
  - [x] 22.3 Create sample data seeders (optional)
    - Sample news, facilities, tendik untuk testing
    - _Requirements: 1.3, 1.4, 1.5_

- [x] 23. Optimize Assets and Performance
  - [x] 23.1 Configure Vite untuk production build
    - Minify CSS dan JavaScript
    - _Requirements: 6.7_
  
  - [x] 23.2 Implement image optimization
    - Integrate ImageService dengan file uploads
    - Auto-resize dan compress saat upload
    - _Requirements: 6.6, 8.6_
  
  - [x] 23.3 Implement lazy loading untuk images
    - Lazy load images di frontend
    - _Requirements: 6.7_
  
- [ ] 24. Final Testing and Integration
  - [ ] 24.1 Run all property-based tests

    - Verify semua properties pass dengan 100+ iterations
    - _Requirements: All_
  
  - [ ]* 24.2 Run all unit tests
    - Verify code coverage
    - _Requirements: All_
  
  - [x] 24.3 Manual testing di browser
    - Test semua fitur di admin panel
    - Test frontend di berbagai devices
    - Test registration flow end-to-end
    - _Requirements: All_
  
  - [x] 24.4 Performance testing
    - Verify page load time < 3 detik
    - Test dengan multiple concurrent users
    - _Requirements: 6.7_

- [x] 25. Final Checkpoint
  - Ensure semua tests pass
  - Verify website berjalan dengan baik
  - Tanyakan user untuk review final

## Notes

- Tasks marked dengan `*` adalah optional dan bisa di-skip untuk MVP lebih cepat
- Setiap task reference specific requirements untuk traceability
- Checkpoints memastikan validasi incremental
- Property tests validate universal correctness properties
- Unit tests validate specific examples dan edge cases
- CBT system dibuat kerangka dasar dulu, akan dikembangkan lebih lanjut sesuai kebutuhan
- Focus pada banyak CRUD di Filament sesuai permintaan klien