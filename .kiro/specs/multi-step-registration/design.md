# Design Document: Multi-Step Registration System

## Overview

Sistem pendaftaran mahasiswa baru multi-step yang memungkinkan calon mahasiswa untuk:
1. Mencari dan memilih jalur pendaftaran dengan filter
2. Mengisi formulir pendaftaran (data pribadi + pilihan prodi) dalam satu halaman
3. Review/konfirmasi data dengan opsi edit sebelum submit
4. Melakukan pembayaran (voucher + metode pembayaran)

Implementasi menggunakan Laravel dengan Filament admin panel, session-based multi-step flow, dan Blade templates dengan Tailwind CSS.

## Architecture

### High-Level Architecture

```
┌─────────────────┐
│   Applicant     │
│   (Browser)     │
└────────┬────────┘
         │
         ▼
┌─────────────────────────────────────────┐
│         Laravel Application             │
│  ┌───────────────────────────────────┐  │
│  │   Multi-Step Registration Flow    │  │
│  │  1. Search & Select Path          │  │
│  │  2. Registration Form             │  │
│  │  3. Confirmation/Review           │  │
│  │  4. Payment (Later)               │  │
│  └───────────────────────────────────┘  │
│                                         │
│  ┌───────────────────────────────────┐  │
│  │      Controllers Layer            │  │
│  │  - RegistrationPathController     │  │
│  │  - MultiStepRegistrationController│  │
│  └───────────────────────────────────┘  │
│                                         │
│  ┌───────────────────────────────────┐  │
│  │      Services Layer               │  │
│  │  - RegistrationService            │  │
│  │  - VoucherService                 │  │
│  │  - PaymentService                 │  │
│  └───────────────────────────────────┘  │
│                                         │
│  ┌───────────────────────────────────┐  │
│  │      Models Layer                 │  │
│  │  - Registration                   │  │
│  │  - RegistrationPath               │  │
│  │  - StudyProgram                   │  │
│  │  - Voucher                        │  │
│  │  - PaymentMethod                  │  │
│  └───────────────────────────────────┘  │
└─────────────────────────────────────────┘
         │
         ▼
┌─────────────────┐
│    Database     │
│    (MySQL)      │
└─────────────────┘
```

### Multi-Step Flow Diagram

```
┌──────────────────┐
│  Step 1: Search  │
│  & Select Path   │
│  - Filter jalur  │
│  - Lihat detail  │
│  - Daftar        │
└────────┬─────────┘
         │
         ▼
┌──────────────────┐
│  Step 2: Form    │
│  - Data pribadi  │
│  - Pilihan prodi │
│  - Referral code │
└────────┬─────────┘
         │
         ▼
┌──────────────────┐
│  Step 3: Review  │◄──┐
│  - Konfirmasi    │   │ Ubah Data
│  - Checkbox      │───┘
└────────┬─────────┘
         │
         ▼
┌──────────────────┐
│  Step 4: Payment │
│  - Voucher       │
│  - Metode bayar  │
│  (Later)         │
└──────────────────┘
```

### Session-Based Multi-Step Flow

The registration process uses Laravel sessions to maintain state across steps:

1. Step 1: Store selected registration_path_id in session
2. Step 2: Store personal info + program selections in session
3. Step 3: Display all session data for review, allow edit
4. Step 4: Store payment info, create registration record
5. Clear session after successful registration

## Components and Interfaces

### 1. Database Models

#### RegistrationPath Model

```php
class RegistrationPath extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'description',
        'registration_fee',
        'start_date',
        'end_date',
        'is_active',
        'quota',
        'requirements',
        'system_type',      // 'reguler', 'karyawan'
        'degree_level',     // 'S1', 'D3', 'S2'
        'wave',             // 'Gelombang 1', 'Gelombang 2'
        'period'            // '2026 Ganjil'
    ];
    
    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'is_active' => 'boolean',
        'registration_fee' => 'decimal:2',
        'requirements' => 'array'
    ];
    
    public function registrations(): HasMany;
    public function studyPrograms(): BelongsToMany;
    public function isOpen(): bool;
    public function hasQuotaAvailable(): bool;
    
    // Scopes for filtering
    public function scopeActive($query);
    public function scopeByDegreeLevel($query, $level);
    public function scopeBySystemType($query, $type);
    public function scopeByStudyProgram($query, $programId);
}
```

#### StudyProgram Model

```php
class StudyProgram extends Model
{
    protected $fillable = [
        'name',
        'code',
        'faculty',
        'degree_level',     // 'S1', 'D3', 'S2'
        'program_type',     // 'IPA', 'IPS'
        'description',
        'is_active'
    ];
    
    protected $casts = [
        'is_active' => 'boolean'
    ];
    
    public function registrations(): HasMany;
    public function registrationPaths(): BelongsToMany;
    
    // Scopes for filtering
    public function scopeActive($query);
    public function scopeByProgramType($query, $type);
    public function scopeByDegreeLevel($query, $level);
}
```

#### Enhanced Registration Model

```php
class Registration extends Model
{
    protected $fillable = [
        'registration_number',
        'registration_path_id',
        'first_choice_program_id',
        'second_choice_program_id',
        'program_type',         // 'IPA', 'IPS'
        'name',
        'email',
        'phone',
        'date_of_birth',
        'referral_code',
        'voucher_code',
        'payment_method',
        'payment_amount',
        'discount_amount',
        'final_amount',
        'payment_status',
        'payment_date',
        'status',
        'data_confirmed_at'     // timestamp when user confirmed data
    ];
    
    protected $casts = [
        'date_of_birth' => 'date',
        'payment_date' => 'datetime',
        'data_confirmed_at' => 'datetime',
        'payment_amount' => 'decimal:2',
        'discount_amount' => 'decimal:2',
        'final_amount' => 'decimal:2'
    ];
    
    public function registrationPath(): BelongsTo;
    public function firstChoiceProgram(): BelongsTo;
    public function secondChoiceProgram(): BelongsTo;
}
```

#### Voucher Model

```php
class Voucher extends Model
{
    protected $fillable = [
        'code',
        'type',             // 'percentage', 'fixed'
        'value',
        'max_uses',
        'used_count',
        'valid_from',
        'valid_until',
        'is_active',
        'applicable_paths'  // JSON array of path IDs
    ];
    
    protected $casts = [
        'valid_from' => 'datetime',
        'valid_until' => 'datetime',
        'is_active' => 'boolean',
        'value' => 'decimal:2',
        'applicable_paths' => 'array'
    ];
    
    public function isValid(): bool;
    public function canBeUsed(): bool;
    public function calculateDiscount(float $amount): float;
}
```

#### PaymentMethod Model

```php
class PaymentMethod extends Model
{
    protected $fillable = [
        'name',
        'code',
        'logo',
        'admin_fee',
        'instructions',
        'is_active',
        'sort_order'
    ];
    
    protected $casts = [
        'is_active' => 'boolean',
        'admin_fee' => 'decimal:2',
        'instructions' => 'array'
    ];
}
```

### 2. Controllers

#### MultiStepRegistrationController

```php
class MultiStepRegistrationController extends Controller
{
    // Step 1: Search and filter paths
    public function searchPaths(Request $request): View;
    
    // Step 1: Show path detail
    public function showPathDetail(RegistrationPath $path): View;
    
    // Step 1: Select path and proceed to form
    public function selectPath(RegistrationPath $path): RedirectResponse;
    
    // Step 2: Show registration form (personal info + programs)
    public function showForm(): View;
    
    // Step 2: Store form data
    public function storeForm(StoreRegistrationFormRequest $request): RedirectResponse;
    
    // Step 3: Show confirmation/review page
    public function showConfirmation(): View;
    
    // Step 3: Go back to edit form
    public function editForm(): RedirectResponse;
    
    // Step 3: Confirm data and proceed to payment
    public function confirmData(Request $request): RedirectResponse;
    
    // Step 4: Show payment page
    public function showPayment(): View;
    
    // Step 4: Apply voucher (AJAX)
    public function applyVoucher(Request $request): JsonResponse;
    
    // Step 4: Process payment
    public function processPayment(StorePaymentRequest $request): RedirectResponse;
    
    // Success page
    public function showSuccess(): View;
    
    // Change path (from form page)
    public function changePath(): RedirectResponse;
    
    // Restart registration
    public function restart(): RedirectResponse;
    
    // Get programs by type (AJAX)
    public function getProgramsByType(Request $request): JsonResponse;
}
```

### 3. Services

#### RegistrationService

```php
class RegistrationService
{
    public function __construct(
        private VoucherService $voucherService,
        private PaymentService $paymentService
    ) {}
    
    public function createFromSession(array $sessionData): Registration;
    public function generateRegistrationNumber(): string;
    public function calculateFinalAmount(float $baseAmount, ?string $voucherCode): array;
    public function sendConfirmationEmail(Registration $registration): bool;
}
```

#### VoucherService

```php
class VoucherService
{
    public function validate(string $code, int $pathId): array;
    public function applyDiscount(Voucher $voucher, float $amount): float;
    public function markAsUsed(Voucher $voucher): void;
    public function canBeUsed(Voucher $voucher): bool;
}
```

#### PaymentService

```php
class PaymentService
{
    public function getActiveMethods(): Collection;
    public function calculateTotal(float $amount, string $methodCode): float;
    public function getInstructions(string $methodCode, Registration $registration): array;
}
```

### 4. Form Requests

#### StoreRegistrationFormRequest

```php
class StoreRegistrationFormRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            // Personal Info
            'name' => 'required|string|max:255|regex:/^[a-zA-Z\s]+$/',
            'email' => 'required|email|max:255',
            'phone' => 'required|regex:/^(\+62|62|0)[0-9]{9,12}$/',
            'date_of_birth' => 'required|date|before:' . now()->subYears(15)->format('Y-m-d'),
            
            // Program Selection
            'program_type' => 'required|in:IPA,IPS',
            'first_choice_program_id' => 'required|exists:study_programs,id',
            'second_choice_program_id' => 'nullable|exists:study_programs,id|different:first_choice_program_id',
            
            // Optional
            'referral_code' => 'nullable|string|max:50'
        ];
    }
    
    public function messages(): array
    {
        return [
            'name.regex' => 'Nama hanya boleh berisi huruf dan spasi',
            'phone.regex' => 'Format nomor HP tidak valid',
            'date_of_birth.before' => 'Usia minimal 15 tahun',
            'second_choice_program_id.different' => 'Pilihan 2 harus berbeda dengan Pilihan 1'
        ];
    }
}
```

#### StorePaymentRequest

```php
class StorePaymentRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'voucher_code' => 'nullable|string|max:50',
            'payment_method' => 'required|exists:payment_methods,code'
        ];
    }
}
```

## Data Models

### Database Schema

#### registration_paths table (updated)

```sql
CREATE TABLE registration_paths (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    slug VARCHAR(255) UNIQUE NOT NULL,
    description TEXT,
    registration_fee DECIMAL(10,2) NOT NULL,
    start_date DATETIME NOT NULL,
    end_date DATETIME NOT NULL,
    is_active BOOLEAN DEFAULT TRUE,
    quota INT UNSIGNED,
    requirements JSON,
    system_type VARCHAR(50) NOT NULL,       -- 'reguler', 'karyawan'
    degree_level VARCHAR(10) NOT NULL,      -- 'S1', 'D3', 'S2'
    wave VARCHAR(50),                       -- 'Gelombang 1', 'Gelombang 2'
    period VARCHAR(50),                     -- '2026 Ganjil'
    created_at TIMESTAMP,
    updated_at TIMESTAMP,
    INDEX idx_slug (slug),
    INDEX idx_active_dates (is_active, start_date, end_date),
    INDEX idx_filters (degree_level, system_type, is_active)
);
```

#### study_programs table (updated)

```sql
CREATE TABLE study_programs (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    code VARCHAR(50) UNIQUE NOT NULL,
    faculty VARCHAR(255),
    degree_level VARCHAR(10) NOT NULL,      -- 'S1', 'D3', 'S2'
    program_type VARCHAR(10) NOT NULL,      -- 'IPA', 'IPS'
    description TEXT,
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP,
    updated_at TIMESTAMP,
    INDEX idx_code (code),
    INDEX idx_active (is_active),
    INDEX idx_program_type (program_type, is_active)
);
```

#### registration_path_study_program pivot table

```sql
CREATE TABLE registration_path_study_program (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    registration_path_id BIGINT UNSIGNED NOT NULL,
    study_program_id BIGINT UNSIGNED NOT NULL,
    created_at TIMESTAMP,
    updated_at TIMESTAMP,
    FOREIGN KEY (registration_path_id) REFERENCES registration_paths(id) ON DELETE CASCADE,
    FOREIGN KEY (study_program_id) REFERENCES study_programs(id) ON DELETE CASCADE,
    UNIQUE KEY unique_path_program (registration_path_id, study_program_id)
);
```

#### registrations table (updated)

```sql
CREATE TABLE registrations (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    registration_number VARCHAR(50) UNIQUE NOT NULL,
    registration_path_id BIGINT UNSIGNED NOT NULL,
    first_choice_program_id BIGINT UNSIGNED NOT NULL,
    second_choice_program_id BIGINT UNSIGNED,
    program_type VARCHAR(10),               -- 'IPA', 'IPS'
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    phone VARCHAR(20) NOT NULL,
    date_of_birth DATE NOT NULL,
    referral_code VARCHAR(50),
    voucher_code VARCHAR(50),
    payment_method VARCHAR(50),
    payment_amount DECIMAL(10,2),
    discount_amount DECIMAL(10,2) DEFAULT 0,
    final_amount DECIMAL(10,2),
    payment_status VARCHAR(50) DEFAULT 'unpaid',
    payment_date DATETIME,
    status VARCHAR(50) DEFAULT 'pending',
    data_confirmed_at DATETIME,
    created_at TIMESTAMP,
    updated_at TIMESTAMP,
    FOREIGN KEY (registration_path_id) REFERENCES registration_paths(id),
    FOREIGN KEY (first_choice_program_id) REFERENCES study_programs(id),
    FOREIGN KEY (second_choice_program_id) REFERENCES study_programs(id),
    INDEX idx_registration_number (registration_number),
    INDEX idx_email (email),
    INDEX idx_status (status),
    INDEX idx_payment_status (payment_status)
);
```


## UI/UX Design

### Step 1: Search & Select Path Page

```
┌─────────────────────────────────────────────────────────────┐
│  Jalur Pendaftaran                                          │
│  Temukan jalur pendaftaran sesuai dengan pilihan program    │
│  studi yang diminati.                                       │
│                                                             │
│  ┌─────────────┐ ┌─────────────┐ ┌─────────────┐ ┌────────┐│
│  │Pilih Jenjang│ │Pilih Prodi  │ │Sistem Kuliah│ │ Cari   ││
│  │     ▼       │ │     ▼       │ │     ▼       │ │        ││
│  └─────────────┘ └─────────────┘ └─────────────┘ └────────┘│
│                                                             │
│  ┌─────────────────────────────────────────────────────────┐│
│  │ USM Reguler - USM-Sarjana Gelombang 1                   ││
│  │ Untuk informasi lainnya bisa kontak hotline PMB...      ││
│  │ [Reguler]                                               ││
│  │                          📅 5 Jan 2026 - 10 Apr 2026    ││
│  │                          💰 Biaya Daftar Rp. 300.000    ││
│  │                                    [Daftar Sekarang]    ││
│  └─────────────────────────────────────────────────────────┘│
└─────────────────────────────────────────────────────────────┘
```

### Step 1b: Path Detail Page

```
┌─────────────────────────────────────────────────────────────┐
│  USM Reguler - USM-Sarjana Gelombang 1                      │
│                                                             │
│  Detail Jalur Pendaftaran                                   │
│  ─────────────────────────────────────────────────────────  │
│  Periode        : 2026 Ganjil    Sistem Kuliah : Reguler    │
│  Masa Pendaftaran: 5 Jan - 10 Apr 2026  Gelombang: Gelombang 1│
│  Jenjang        : STRATA 1       Biaya Daftar  : Rp 300.000 │
│                                                             │
│  Jalur USM-Sarjana                                          │
│  Melalui tes tulis peserta didik baru dari SMA/SMK          │
│                                                             │
│  Persyaratan Administrasi                                   │
│  • PASFOTO WARNA, TERBARU, LATAR MERAH...                   │
│  • Dokumen Persetujuan Ketentuan Pengembalian...            │
│                                                             │
│  ┌─────────────────────────┐                                │
│  │ Pilihan Program Studi   │                                │
│  │ Silakan pilih program   │                                │
│  │ studi yang kamu minati  │                                │
│  │ ┌─────────────────────┐ │                                │
│  │ │ Pilih Program Studi▼│ │                                │
│  │ └─────────────────────┘ │                                │
│  │ [Lanjutkan Mendaftar →] │                                │
│  └─────────────────────────┘                                │
└─────────────────────────────────────────────────────────────┘
```

### Step 2: Registration Form Page

```
┌─────────────────────────────────────────────────────────────┐
│  Formulir Pendaftaran                                       │
│  Lengkapi data pendaftaran untuk melanjutkan ke tahap       │
│  selanjutnya.                                               │
│                                                             │
│  Kamu Memilih Jalur Pendaftaran                             │
│  ┌─────────────────────────────────────────────────────────┐│
│  │ 🎓 USM Reguler - USM-Sarjana Gelombang 1                ││
│  │    Reguler                           [Pindah Jalur]     ││
│  └─────────────────────────────────────────────────────────┘│
│                                                             │
│  Lengkapi Datamu Sekarang                                   │
│  Jangan sampai kehabisan kuota!                             │
│                                                             │
│  Informasi Pribadi                                          │
│  ┌────────────────────────┐ ┌────────────────────────┐      │
│  │ Nama Lengkap *         │ │ No. HP *               │      │
│  │ [________________]     │ │ [________________]     │      │
│  └────────────────────────┘ └────────────────────────┘      │
│  ┌────────────────────────┐ ┌────────────────────────┐      │
│  │ Alamat Email *         │ │ Tanggal Lahir *        │      │
│  │ [________________]     │ │ [dd-mm-yyyy]           │      │
│  └────────────────────────┘ └────────────────────────┘      │
│                                                             │
│  Pilihan Program Studi                                      │
│  ┌────────────────────────┐                                 │
│  │ Jenis Program yang Dituju * │                            │
│  │ [IPS                  ▼]    │                            │
│  └────────────────────────┘                                 │
│  ┌────────────────────────┐ ┌────────────────────────┐      │
│  │ Pilihan 1 *            │ │ Pilihan 2              │      │
│  │ [S1 - Akuntansi    ▼]  │ │ [-- Pilih Pilihan 2 ▼] │      │
│  └────────────────────────┘ └────────────────────────┘      │
│                                                             │
│  Referral                                                   │
│  ┌────────────────────────┐                                 │
│  │ Kode Referral          │                                 │
│  │ [________________]     │                                 │
│  └────────────────────────┘                                 │
│                                                             │
│                              [Lanjutkan Mendaftar →]        │
└─────────────────────────────────────────────────────────────┘
```

### Step 3: Confirmation/Review Page

```
┌─────────────────────────────────────────────────────────────┐
│  Konfirmasi Data Pendaftaran                                │
│                                                             │
│  Kamu Memilih Jalur Pendaftaran                             │
│  ┌─────────────────────────────────────────────────────────┐│
│  │ 🎓 USM Reguler - USM-Sarjana Gelombang 1                ││
│  │    Reguler                                              ││
│  └─────────────────────────────────────────────────────────┘│
│                                                             │
│  Informasi Pribadi                                          │
│  ─────────────────────────────────────────────────────────  │
│  Nama Lengkap    : John Doe                                 │
│  No Handphone    : 081234567890                             │
│  Alamat Email    : john@example.com                         │
│  Tanggal Lahir   : 9 Januari 2006                           │
│                                                             │
│  Pilihan Program Studi                                      │
│  ─────────────────────────────────────────────────────────  │
│  Jenis Program   : IPS                                      │
│  Pilihan 1       : S1 - Administrasi Publik                 │
│  Pilihan 2       : S1 - Akuntansi                           │
│                                                             │
│  ┌─────────────────────────────────────────────────────────┐│
│  │ ☐ Saya menyetujui bahwa data yang telah dimasukkan     ││
│  │   adalah Benar dan dapat dipertanggungjawabkan.        ││
│  └─────────────────────────────────────────────────────────┘│
│                                                             │
│  [Ubah Data]                    [Lanjutkan Mendaftar →]     │
└─────────────────────────────────────────────────────────────┘
```

### Step 4: Payment Page

```
┌─────────────────────────────────────────────────────────────┐
│  Pilih Metode Pembayaran                                    │
│  Pilih metode pembayaran dan segera lakukan pembayaran      │
│  biaya formulir                                             │
│                                                             │
│  Kamu Memilih Jalur Pendaftaran                             │
│  ┌─────────────────────────────────────────────────────────┐│
│  │ 🎓 USM Reguler - USM-Sarjana Gelombang 1                ││
│  │    Reguler                                              ││
│  └─────────────────────────────────────────────────────────┘│
│                                                             │
│  Voucher Pendaftaran                                        │
│  ┌────────────────────────────────────┐ ┌────────┐          │
│  │ Kode voucher                       │ │Terapkan│          │
│  └────────────────────────────────────┘ └────────┘          │
│                                                             │
│  Pilih Metode Pembayaran                                    │
│  ┌─────────────────────────────────────────────────────────┐│
│  │ ○ TOKOPEDIA                              [logo]         ││
│  │   Biaya admin Rp. 4.000                                 ││
│  ├─────────────────────────────────────────────────────────┤│
│  │ ○ BANK MANDIRI                           [logo]         ││
│  │   Biaya admin Rp. 4.000                                 ││
│  ├─────────────────────────────────────────────────────────┤│
│  │ ○ Shopee                                 [logo]         ││
│  │   Biaya admin Rp. 4.000                                 ││
│  ├─────────────────────────────────────────────────────────┤│
│  │ ○ BANK BJB                               [logo]         ││
│  │   Biaya admin Rp. 3.000                                 ││
│  └─────────────────────────────────────────────────────────┘│
│                                                             │
│  ┌─────────────────────────┐                                │
│  │ Detail Pembayaran       │                                │
│  │ Biaya Formulir: 300.000 │                                │
│  │ Total Pembayaran:300.000│                                │
│  │ [        💳 Bayar      ]│                                │
│  └─────────────────────────┘                                │
└─────────────────────────────────────────────────────────────┘
```


## Correctness Properties

*A property is a characteristic or behavior that should hold true across all valid executions of a system—essentially, a formal statement about what the system should do. Properties serve as the bridge between human-readable specifications and machine-verifiable correctness guarantees.*

### Property 1: Registration Path Filter Results
*For any* combination of filter criteria (degree level, program type, study system), all returned registration paths should match ALL applied filter criteria.
**Validates: Requirements 1.2**

### Property 2: Registration Path Date Validation
*For any* registration path selection, if the current date is outside the path's start_date and end_date range, then the system should reject the selection and display an error message.
**Validates: Requirements 1.4, 1.5**

### Property 3: Name Validation
*For any* name input string, the system should accept it only if it contains only letters (a-z, A-Z) and spaces, rejecting any strings with numbers or special characters.
**Validates: Requirements 3.5**

### Property 4: Indonesian Phone Number Validation
*For any* phone number input, the system should accept it only if it matches valid Indonesian phone number formats: starting with +62, 62, or 0, followed by 9-12 digits.
**Validates: Requirements 3.6**

### Property 5: Email Format Validation
*For any* email input string, the system should accept it only if it matches valid email format (contains @ symbol, valid domain structure).
**Validates: Requirements 3.7**

### Property 6: Minimum Age Validation
*For any* date of birth input, the system should accept it only if the applicant is at least 15 years old (date of birth is before current date minus 15 years).
**Validates: Requirements 3.8**

### Property 7: Program Type Filtering
*For any* program type selection (IPA/IPS), the system should only display study programs that match the selected program type.
**Validates: Requirements 3.9**

### Property 8: Program Selection Uniqueness
*For any* program selection where both first and second choices are provided, the first choice program ID must be different from the second choice program ID.
**Validates: Requirements 3.10**

### Property 9: Required Fields Validation
*For any* registration form submission, if any required field (name, email, phone, date_of_birth, program_type, first_choice_program_id) is empty or invalid, then the system should reject the submission.
**Validates: Requirements 3.11**

### Property 10: Confirmation Page Data Consistency
*For any* confirmation page display, all shown data (registration path, personal info, program selections) should exactly match the data stored in the session.
**Validates: Requirements 4.2, 4.3, 4.4**

### Property 11: Edit Form Data Preservation
*For any* "Ubah Data" action from the confirmation page, all previously entered data should be preserved and displayed in the form fields.
**Validates: Requirements 4.7**

### Property 12: Voucher Validation and Discount Calculation
*For any* voucher code submission, if the voucher is valid (exists, not expired, not max uses reached, applicable to path), the discount should be calculated correctly based on voucher type (percentage or fixed), and the discount amount should not exceed the registration fee.
**Validates: Requirements 5.3, 5.4, 5.5**

### Property 13: Payment Summary Calculation
*For any* payment page display, the payment summary should correctly show: registration fee, discount amount (if voucher applied), admin fee (based on selected method), and total payment.
**Validates: Requirements 5.7**

### Property 14: Registration Data Persistence
*For any* confirmed registration, all entered data (registration path, programs, personal info, payment method, voucher/referral codes, timestamps) should be stored in the database and retrievable.
**Validates: Requirements 6.1, 6.2, 6.4, 6.5**

### Property 15: Unique Registration Number Generation
*For any* two registrations created at any time, their registration numbers must be unique (no two registrations can have the same registration_number).
**Validates: Requirements 6.3**

### Property 16: Email Sending Resilience
*For any* registration submission, even if email sending fails, the registration should still be created successfully in the database and the applicant should see the success page.
**Validates: Requirements 7.6**

### Property 17: Session Data Preservation on Navigation
*For any* multi-step registration session, when navigating between steps (forward or backward), all previously entered data should be preserved.
**Validates: Requirements 8.3, 8.5**

### Property 18: Step Access Control
*For any* attempt to access a registration step directly via URL, if previous steps have not been completed, then the system should redirect to the first incomplete step.
**Validates: Requirements 8.4**

### Property 19: Session Expiration Handling
*For any* expired session, when the user attempts to access any registration step, the system should redirect to the start page and display a timeout message.
**Validates: Requirements 8.6**

## Error Handling

### Validation Errors

**Client-Side Validation:**
- Real-time validation for form fields
- Display inline error messages in Indonesian
- Prevent form submission until all errors are resolved

**Server-Side Validation:**
- Validate all inputs using Form Requests
- Return validation errors with 422 status code
- Display errors in user-friendly format

### Session Errors

**Session Expiration:**
- Check session validity at each step
- Redirect to start with timeout message if expired
- Clear any partial data

**Invalid Session Data:**
- Validate session data structure at each step
- Redirect to start if data is corrupted
- Log errors for debugging

### Database Errors

**Transaction Failures:**
- Wrap registration creation in database transaction
- Rollback all changes if any part fails
- Display generic error message to user
- Log detailed error for administrators

**Unique Constraint Violations:**
- Handle duplicate registration numbers gracefully
- Retry with new registration number

### External Service Errors

**Email Service Failures:**
- Log email sending errors
- Continue registration process
- Queue email for retry
- Display success message to user

### User Input Errors

**Invalid Voucher Codes:**
- Display specific error message (expired, invalid, max uses reached)
- Allow user to try different code or proceed without voucher

**Closed Registration Paths:**
- Display closure message with dates
- Redirect to path search
- Show only open paths

## Testing Strategy

### Unit Testing

Unit tests will verify specific functionality and edge cases:

**Model Tests:**
- Test model relationships
- Test model scopes (filtering)
- Test date casting and attribute accessors
- Test validation rules in models

**Service Tests:**
- Test RegistrationService methods
- Test VoucherService validation and discount calculation
- Test PaymentService method retrieval and total calculation

**Controller Tests:**
- Test each step's GET and POST methods
- Test session data storage and retrieval
- Test redirect logic between steps
- Test error handling and validation

**Validation Tests:**
- Test Form Request validation rules
- Test custom validation messages
- Test edge cases for each validation rule

### Property-Based Testing

Property-based tests will verify universal properties across all inputs using Eris library for PHP. Each test will run a minimum of 100 iterations with randomly generated inputs.

**Configuration:**
- Use Eris library for property-based testing in PHP
- Configure each test to run 100+ iterations
- Generate random valid and invalid inputs
- Tag each test with feature name and property number

**Test Tags Format:**
```php
/**
 * @test
 * Feature: multi-step-registration, Property 1: Registration Path Filter Results
 */
```

### Integration Testing

Integration tests will verify end-to-end flows:

**Complete Registration Flow:**
- Test full registration from path search to success
- Verify database records created correctly
- Verify email sent (using mail fake)
- Test with various combinations of inputs

**Multi-Step Navigation:**
- Test forward and backward navigation
- Verify session data persistence
- Test step access control

## Implementation Notes

### Technology Stack

- **Framework:** Laravel 11.x
- **Admin Panel:** Filament 3.x
- **Database:** MySQL 8.0+
- **Frontend:** Blade templates with Tailwind CSS
- **Session Storage:** Database-backed sessions
- **Email:** Laravel Mail with queue support
- **Property Testing:** Eris library

### Routes Structure

```php
// Registration routes
Route::prefix('pendaftaran')->name('registration.')->group(function () {
    // Step 1: Search and select path
    Route::get('/', [MultiStepRegistrationController::class, 'searchPaths'])->name('search');
    Route::get('/jalur/{path:slug}', [MultiStepRegistrationController::class, 'showPathDetail'])->name('path.detail');
    Route::post('/jalur/{path}/pilih', [MultiStepRegistrationController::class, 'selectPath'])->name('path.select');
    
    // Step 2: Registration form
    Route::get('/formulir', [MultiStepRegistrationController::class, 'showForm'])->name('form');
    Route::post('/formulir', [MultiStepRegistrationController::class, 'storeForm'])->name('form.store');
    Route::get('/pindah-jalur', [MultiStepRegistrationController::class, 'changePath'])->name('change-path');
    
    // Step 3: Confirmation
    Route::get('/konfirmasi', [MultiStepRegistrationController::class, 'showConfirmation'])->name('confirmation');
    Route::get('/edit', [MultiStepRegistrationController::class, 'editForm'])->name('edit');
    Route::post('/konfirmasi', [MultiStepRegistrationController::class, 'confirmData'])->name('confirm');
    
    // Step 4: Payment
    Route::get('/pembayaran', [MultiStepRegistrationController::class, 'showPayment'])->name('payment');
    Route::post('/voucher', [MultiStepRegistrationController::class, 'applyVoucher'])->name('voucher.apply');
    Route::post('/pembayaran', [MultiStepRegistrationController::class, 'processPayment'])->name('payment.process');
    
    // Success
    Route::get('/sukses', [MultiStepRegistrationController::class, 'showSuccess'])->name('success');
    
    // Utilities
    Route::get('/restart', [MultiStepRegistrationController::class, 'restart'])->name('restart');
    Route::get('/programs/{type}', [MultiStepRegistrationController::class, 'getProgramsByType'])->name('programs.by-type');
});
```

### Session Data Structure

```php
// Session key: 'registration'
[
    'step' => 1|2|3|4,
    'path_id' => int,
    'form_data' => [
        'name' => string,
        'email' => string,
        'phone' => string,
        'date_of_birth' => string,
        'program_type' => 'IPA'|'IPS',
        'first_choice_program_id' => int,
        'second_choice_program_id' => int|null,
        'referral_code' => string|null,
    ],
    'data_confirmed' => bool,
    'voucher' => [
        'code' => string|null,
        'discount' => float,
    ],
    'payment_method' => string|null,
]
```

### Security Considerations

**Input Validation:**
- Sanitize all user inputs
- Use parameterized queries (Eloquent ORM)
- Implement CSRF protection (Laravel default)

**Session Security:**
- Use secure session cookies
- Implement session timeout
- Regenerate session ID after each step
- Clear sensitive data after registration

**Access Control:**
- Protect admin routes with authentication
- Validate step access in middleware
- Prevent unauthorized data access
