# Requirements Document

## Introduction

Sistem pendaftaran mahasiswa baru multi-step yang memungkinkan calon mahasiswa untuk mencari dan memilih jalur pendaftaran, mengisi formulir pendaftaran (data pribadi + pilihan prodi), melakukan review/konfirmasi data sebelum submit, dan melakukan pembayaran. Flow dirancang agar user dapat mengedit data jika ada kesalahan sebelum finalisasi.

## Glossary

- **System**: Sistem pendaftaran mahasiswa baru berbasis web
- **Registration_Path**: Jalur pendaftaran yang tersedia (USM Reguler, Prestasi Akademik, PMDK, dll)
- **Study_Program**: Program studi yang ditawarkan oleh universitas (S1 Administrasi Publik, S1 Akuntansi, dll)
- **Degree_Level**: Jenjang pendidikan (S1, D3, S2)
- **Study_System**: Sistem kuliah (Reguler, Karyawan/Eksekutif)
- **Applicant**: Calon mahasiswa yang melakukan pendaftaran
- **Payment_Method**: Metode pembayaran yang tersedia (Tokopedia, Bank Mandiri, Shopee, Bank BJB)
- **Registration_Fee**: Biaya pendaftaran yang harus dibayar
- **Voucher**: Kode voucher untuk diskon atau potongan biaya
- **Referral_Code**: Kode referral untuk mendapatkan benefit tertentu

## Requirements

### Requirement 1: Pencarian dan Pemilihan Jalur Pendaftaran

**User Story:** As an applicant, I want to search and filter registration paths, so that I can find the appropriate admission route for my needs.

#### Acceptance Criteria

1. WHEN an applicant visits the registration page, THE System SHALL display a search interface with filter options for degree level (jenjang), study program (prodi), and study system (sistem kuliah)
2. WHEN an applicant applies filters, THE System SHALL display matching registration paths with their details (name, period, fee, wave/gelombang)
3. WHEN an applicant clicks on a registration path, THE System SHALL display the path detail page showing complete information (period, fee, requirements, description)
4. THE System SHALL validate that the selected registration path is currently open for registration
5. IF a registration path is closed, THEN THE System SHALL display a warning message and prevent selection
6. WHEN an applicant clicks "Daftar Sekarang" on a path, THE System SHALL proceed to the registration form step

### Requirement 2: Konfirmasi Jalur Pendaftaran

**User Story:** As an applicant, I want to confirm my selected registration path before filling the form, so that I can ensure I chose the correct path.

#### Acceptance Criteria

1. WHEN an applicant selects a registration path, THE System SHALL display the selected path information prominently at the top of the form
2. THE System SHALL display path details including name, type (Reguler/Karyawan), period, wave, fee, and requirements
3. THE System SHALL provide a "Pindah Jalur" option to allow changing the selected path
4. WHEN an applicant clicks "Pindah Jalur", THE System SHALL redirect back to the path search page

### Requirement 3: Formulir Pendaftaran (Data Pribadi + Pilihan Prodi)

**User Story:** As an applicant, I want to fill my personal information and select study programs in one form, so that I can complete the registration efficiently.

#### Acceptance Criteria

1. WHEN an applicant reaches the registration form, THE System SHALL display a combined form with personal information section and study program selection section
2. THE System SHALL display required fields for personal information: full name (Nama Lengkap), phone number (No. HP), email address (Alamat Email), and date of birth (Tanggal Lahir)
3. THE System SHALL display study program selection: program type (Jenis Program - IPA/IPS), first choice (Pilihan 1), and optional second choice (Pilihan 2)
4. THE System SHALL provide an optional referral code field (Kode Referral)
5. WHEN an applicant enters their full name, THE System SHALL validate that it contains only letters and spaces
6. WHEN an applicant enters their phone number, THE System SHALL validate that it is a valid Indonesian phone number format
7. WHEN an applicant enters their email address, THE System SHALL validate that it is a valid email format
8. WHEN an applicant enters their date of birth, THE System SHALL validate that the applicant meets minimum age requirements
9. THE System SHALL filter available study programs based on the selected program type (IPA/IPS)
10. THE System SHALL prevent selecting the same program for both first and second choices
11. THE System SHALL prevent submission if any required field is empty or invalid
12. WHEN all fields are valid and applicant clicks "Lanjutkan Mendaftar", THE System SHALL proceed to the confirmation step

### Requirement 4: Konfirmasi dan Review Data

**User Story:** As an applicant, I want to review all my registration data before final submission, so that I can correct any mistakes.

#### Acceptance Criteria

1. WHEN an applicant completes the form, THE System SHALL display a confirmation page with all entered information
2. THE System SHALL display the selected registration path information
3. THE System SHALL display personal information (name, phone, email, date of birth)
4. THE System SHALL display study program selections (program type, first choice, second choice)
5. THE System SHALL provide a checkbox for applicant to confirm data accuracy with text "Saya menyetujui bahwa data yang telah dimasukkan adalah Benar dan dapat dipertanggungjawabkan"
6. THE System SHALL provide an "Ubah Data" button to return to the form for editing
7. WHEN an applicant clicks "Ubah Data", THE System SHALL return to the form with all previously entered data preserved
8. THE System SHALL disable the "Lanjutkan Mendaftar" button until the confirmation checkbox is checked
9. WHEN an applicant confirms and clicks "Lanjutkan Mendaftar", THE System SHALL proceed to the payment step

### Requirement 5: Pemilihan Metode Pembayaran

**User Story:** As an applicant, I want to select a payment method and apply vouchers, so that I can pay the registration fee through my preferred channel.

#### Acceptance Criteria

1. WHEN an applicant reaches the payment step, THE System SHALL display the selected registration path and fee information
2. THE System SHALL provide an optional voucher code field with "Terapkan" button
3. WHEN an applicant enters a voucher code and clicks "Terapkan", THE System SHALL validate the voucher against the database
4. IF a voucher is valid, THEN THE System SHALL apply the discount and update the total payment display
5. IF a voucher is invalid or expired, THEN THE System SHALL display an error message
6. THE System SHALL display all available payment methods with their logos and admin fee information
7. THE System SHALL display payment summary showing registration fee, discount (if any), and total payment
8. WHEN an applicant selects a payment method, THE System SHALL highlight the selected option
9. THE System SHALL disable the "Bayar" button until a payment method is selected
10. WHEN an applicant clicks "Bayar", THE System SHALL create a registration record and generate payment instructions

### Requirement 6: Penyimpanan Data Pendaftaran

**User Story:** As a system administrator, I want all registration data to be stored securely, so that we can process applications and maintain records.

#### Acceptance Criteria

1. WHEN a registration is submitted, THE System SHALL store all applicant data in the database
2. THE System SHALL store registration path, study program choices, personal information, payment method, and timestamps
3. THE System SHALL generate a unique registration number for the applicant
4. THE System SHALL store voucher and referral code usage if applicable
5. THE System SHALL record the registration status (pending payment, paid, verified, etc.)
6. THE System SHALL ensure data integrity by using database transactions

### Requirement 7: Notifikasi dan Konfirmasi

**User Story:** As an applicant, I want to receive confirmation of my registration, so that I have proof of submission.

#### Acceptance Criteria

1. WHEN a registration is successfully submitted, THE System SHALL display a success page with registration details
2. THE System SHALL display the registration number prominently
3. THE System SHALL display payment instructions and deadline
4. THE System SHALL send a confirmation email to the applicant's email address
5. THE System SHALL include registration number, payment details, and next steps in the email
6. IF email sending fails, THEN THE System SHALL still complete the registration and log the error

### Requirement 8: Multi-Step Navigation

**User Story:** As an applicant, I want to navigate between registration steps, so that I can review or modify information before final submission.

#### Acceptance Criteria

1. THE System SHALL display a progress indicator showing current step and completed steps
2. THE System SHALL allow navigation to previous steps to modify data
3. WHEN an applicant navigates to a previous step, THE System SHALL preserve previously entered data
4. THE System SHALL prevent skipping steps by direct URL access
5. THE System SHALL maintain session data throughout the registration process
6. IF session expires, THEN THE System SHALL redirect to the start and display a timeout message

### Requirement 9: Admin Management Interface

**User Story:** As an administrator, I want to manage registration paths and view registrations, so that I can control the admission process.

#### Acceptance Criteria

1. THE System SHALL provide an admin interface to create and manage registration paths
2. THE System SHALL allow administrators to set registration periods, fees, and quotas for each path
3. THE System SHALL allow administrators to activate or deactivate registration paths
4. THE System SHALL display all registrations with filtering and search capabilities
5. THE System SHALL allow administrators to view detailed registration information
6. THE System SHALL allow administrators to update registration status
7. THE System SHALL allow administrators to manage vouchers and their validity periods
