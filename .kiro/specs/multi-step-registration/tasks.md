# Implementation Plan: Multi-Step Registration System

## Overview

Implementation plan untuk sistem pendaftaran multi-step dengan flow baru:
1. Cari & Pilih Jalur (dengan filter)
2. Formulir Pendaftaran (data pribadi + pilihan prodi)
3. Konfirmasi/Review Data (dengan opsi edit)
4. Pembayaran (voucher + metode) - implementasi nanti

## Tasks

- [x] 1. Update database migrations and models
  - [x] 1.1 Update registration_paths migration to add degree_level, wave, period columns
    - Add degree_level VARCHAR(10) for jenjang (S1, D3, S2)
    - Add wave VARCHAR(50) for gelombang
    - Add period VARCHAR(50) for periode
    - Add indexes for filtering
    - _Requirements: 1.1, 1.2_
  - [x] 1.2 Update study_programs migration to add program_type column
    - Add program_type VARCHAR(10) for IPA/IPS
    - Add index for program_type filtering
    - _Requirements: 3.9_
  - [x] 1.3 Create registration_path_study_program pivot table migration
    - Create pivot table for many-to-many relationship
    - _Requirements: 1.2_
  - [x] 1.4 Update registrations migration to add new fields
    - Add program_type column
    - Add data_confirmed_at timestamp
    - Update existing columns if needed
    - _Requirements: 6.1, 6.2_
  - [x] 1.5 Update RegistrationPath model
    - Add new fillable fields (degree_level, wave, period)
    - Add studyPrograms() BelongsToMany relationship
    - Add scopes: scopeActive, scopeByDegreeLevel, scopeBySystemType, scopeByStudyProgram
    - _Requirements: 1.2, 1.4_
  - [x] 1.6 Update StudyProgram model
    - Add program_type to fillable
    - Add registrationPaths() BelongsToMany relationship
    - Add scopes: scopeByProgramType, scopeByDegreeLevel
    - _Requirements: 3.9_
  - [x] 1.7 Update Registration model
    - Add program_type and data_confirmed_at to fillable
    - Update casts for data_confirmed_at
    - _Requirements: 6.1_

- [ ]* 1.8 Write property test for registration path date validation
  - **Property 2: Registration Path Date Validation**
  - **Validates: Requirements 1.4, 1.5**

- [ ]* 1.9 Write property test for program selection uniqueness
  - **Property 8: Program Selection Uniqueness**
  - **Validates: Requirements 3.10**

- [x] 2. Create/Update Form Request validators
  - [x] 2.1 Create StoreRegistrationFormRequest
    - Validate name (letters and spaces only)
    - Validate email (valid format)
    - Validate phone (Indonesian format: +62/62/0 + 9-12 digits)
    - Validate date_of_birth (minimum age 15)
    - Validate program_type (IPA/IPS)
    - Validate first_choice_program_id (required, exists)
    - Validate second_choice_program_id (optional, different from first)
    - Validate referral_code (optional)
    - Add Indonesian error messages
    - _Requirements: 3.5, 3.6, 3.7, 3.8, 3.10, 3.11_
  - [x] 2.2 Update StorePaymentRequest
    - Validate voucher_code (optional)
    - Validate payment_method (required, exists)
    - _Requirements: 5.3, 5.9_

- [ ]* 2.3 Write property test for name validation
  - **Property 3: Name Validation**
  - **Validates: Requirements 3.5**

- [ ]* 2.4 Write property test for Indonesian phone number validation
  - **Property 4: Indonesian Phone Number Validation**
  - **Validates: Requirements 3.6**

- [ ]* 2.5 Write property test for email format validation
  - **Property 5: Email Format Validation**
  - **Validates: Requirements 3.7**

- [ ]* 2.6 Write property test for minimum age validation
  - **Property 6: Minimum Age Validation**
  - **Validates: Requirements 3.8**

- [ ]* 2.7 Write property test for required fields validation
  - **Property 9: Required Fields Validation**
  - **Validates: Requirements 3.11**

- [x] 3. Update service classes
  - [x] 3.1 Update RegistrationService
    - Update createFromSession to handle new flow
    - Add method to get filtered paths
    - Update generateRegistrationNumber
    - _Requirements: 6.1, 6.3_
  - [x] 3.2 Update VoucherService
    - Ensure validate method works with new flow
    - Ensure applyDiscount calculates correctly
    - _Requirements: 5.3, 5.4, 5.5_

- [ ]* 3.3 Write property test for voucher validation and discount
  - **Property 12: Voucher Validation and Discount Calculation**
  - **Validates: Requirements 5.3, 5.4, 5.5**

- [ ]* 3.4 Write property test for unique registration number
  - **Property 15: Unique Registration Number Generation**
  - **Validates: Requirements 6.3**

- [x] 4. Checkpoint - Ensure migrations and models work
  - Run migrations
  - Test model relationships
  - Ensure all tests pass, ask the user if questions arise.

- [x] 5. Update MultiStepRegistrationController for new flow
  - [x] 5.1 Implement Step 1: Search and filter paths
    - Create searchPaths method with filter parameters (degree_level, program_id, system_type)
    - Create showPathDetail method to display path details
    - Create selectPath method to store path_id in session and redirect to form
    - _Requirements: 1.1, 1.2, 1.3, 1.4, 1.5, 1.6_
  - [x] 5.2 Implement Step 2: Registration form
    - Create showForm method to display combined form (personal info + programs)
    - Create storeForm method to validate and store form data in session
    - Create changePath method to clear session and redirect to search
    - Create getProgramsByType AJAX method to filter programs by IPA/IPS
    - _Requirements: 2.1, 2.2, 2.3, 2.4, 3.1, 3.2, 3.3, 3.4, 3.12_
  - [x] 5.3 Implement Step 3: Confirmation/Review
    - Create showConfirmation method to display all session data
    - Create editForm method to redirect back to form with data preserved
    - Create confirmData method to mark data as confirmed and proceed to payment
    - _Requirements: 4.1, 4.2, 4.3, 4.4, 4.5, 4.6, 4.7, 4.8, 4.9_
  - [x] 5.4 Implement Step 4: Payment (basic structure)
    - Create showPayment method to display payment options
    - Create applyVoucher AJAX method
    - Create processPayment method to create registration and redirect to success
    - _Requirements: 5.1, 5.2, 5.3, 5.4, 5.5, 5.6, 5.7, 5.8, 5.9, 5.10_
  - [x] 5.5 Implement utility methods
    - Create showSuccess method
    - Create restart method to clear session
    - Add step validation middleware logic
    - _Requirements: 7.1, 7.2, 7.3, 8.4_

- [ ]* 5.6 Write property test for confirmation page data consistency
  - **Property 10: Confirmation Page Data Consistency**
  - **Validates: Requirements 4.2, 4.3, 4.4**

- [ ]* 5.7 Write property test for edit form data preservation
  - **Property 11: Edit Form Data Preservation**
  - **Validates: Requirements 4.7**

- [ ]* 5.8 Write property test for step access control
  - **Property 18: Step Access Control**
  - **Validates: Requirements 8.4**

- [x] 6. Update Blade views for new flow
  - [x] 6.1 Create Step 1 views
    - Create search.blade.php with filter dropdowns (jenjang, prodi, sistem kuliah)
    - Create path-detail.blade.php showing full path information
    - Style with Tailwind CSS matching UNPAS design
    - _Requirements: 1.1, 1.2, 1.3_
  - [x] 6.2 Create Step 2 view
    - Create form.blade.php with combined personal info + program selection
    - Add selected path display with "Pindah Jalur" button
    - Add program type dropdown that filters program options via AJAX
    - Add referral code field
    - Style with Tailwind CSS
    - _Requirements: 2.1, 2.2, 2.3, 2.4, 3.1, 3.2, 3.3, 3.4_
  - [x] 6.3 Create Step 3 view
    - Create confirmation.blade.php showing all entered data
    - Add checkbox for data accuracy confirmation
    - Add "Ubah Data" button
    - Add "Lanjutkan Mendaftar" button (disabled until checkbox checked)
    - Style with Tailwind CSS
    - _Requirements: 4.1, 4.2, 4.3, 4.4, 4.5, 4.6, 4.8_
  - [x] 6.4 Update Step 4 view (payment)
    - Update payment.blade.php to match new flow
    - Show selected path info
    - Add voucher input with "Terapkan" button
    - Show payment methods with logos
    - Show payment summary
    - _Requirements: 5.1, 5.2, 5.6, 5.7, 5.8_
  - [x] 6.5 Update success view
    - Update success.blade.php with registration details
    - Show registration number prominently
    - Show payment instructions
    - _Requirements: 7.1, 7.2, 7.3_
  - [x] 6.6 Create/update layout with progress indicator
    - Create registration layout with 4-step progress indicator
    - Highlight current step
    - _Requirements: 8.1_

- [x] 7. Checkpoint - Test UI flow manually
  - Test complete flow from search to confirmation
  - Test "Ubah Data" functionality
  - Test "Pindah Jalur" functionality
  - Ensure all tests pass, ask the user if questions arise.

- [x] 8. Add routes and middleware
  - [x] 8.1 Add routes for new flow
    - Add search route (GET /pendaftaran)
    - Add path detail route (GET /pendaftaran/jalur/{slug})
    - Add path select route (POST /pendaftaran/jalur/{path}/pilih)
    - Add form routes (GET/POST /pendaftaran/formulir)
    - Add change path route (GET /pendaftaran/pindah-jalur)
    - Add confirmation routes (GET/POST /pendaftaran/konfirmasi)
    - Add edit route (GET /pendaftaran/edit)
    - Add payment routes (GET/POST /pendaftaran/pembayaran)
    - Add voucher AJAX route (POST /pendaftaran/voucher)
    - Add success route (GET /pendaftaran/sukses)
    - Add restart route (GET /pendaftaran/restart)
    - Add programs by type AJAX route (GET /pendaftaran/programs/{type})
    - _Requirements: 8.2, 8.4_
  - [x] 8.2 Create RegistrationStepMiddleware
    - Check session has required data for current step
    - Redirect to appropriate step if data missing
    - _Requirements: 8.4_

- [ ]* 8.3 Write property test for session data preservation
  - **Property 17: Session Data Preservation on Navigation**
  - **Validates: Requirements 8.3, 8.5**

- [ ]* 8.4 Write property test for session expiration
  - **Property 19: Session Expiration Handling**
  - **Validates: Requirements 8.6**

- [x] 9. Update Filament resources
  - [x] 9.1 Update RegistrationPathResource
    - Add degree_level field (select: S1, D3, S2)
    - Add wave field
    - Add period field
    - Add studyPrograms relationship field (multi-select)
    - Update table columns
    - _Requirements: 9.1, 9.2, 9.3_
  - [x] 9.2 Update StudyProgramResource
    - Add program_type field (select: IPA, IPS)
    - Update table columns
    - Add filter by program_type
    - _Requirements: 9.1_
  - [x] 9.3 Update RegistrationResource
    - Add program_type column
    - Add data_confirmed_at column
    - Update filters
    - _Requirements: 9.4, 9.5, 9.6_

- [x] 10. Update database seeders
  - [x] 10.1 Update RegistrationPathSeeder
    - Add degree_level, wave, period to sample data
    - Attach study programs to paths
    - _Requirements: 1.1_
  - [x] 10.2 Update StudyProgramSeeder
    - Add program_type (IPA/IPS) to sample data
    - _Requirements: 3.9_

- [x] 11. Add JavaScript for enhanced UX
  - [x] 11.1 Add program type filtering
    - Implement AJAX call to filter programs when program_type changes
    - Update first_choice and second_choice dropdowns
    - _Requirements: 3.9_
  - [x] 11.2 Add voucher validation
    - Implement AJAX voucher validation on "Terapkan" click
    - Update payment summary with discount
    - _Requirements: 5.3, 5.4, 5.5_
  - [x] 11.3 Add confirmation checkbox logic
    - Enable/disable submit button based on checkbox state
    - _Requirements: 4.8_
  - [x] 11.4 Add form validation feedback
    - Show inline validation errors
    - _Requirements: 3.11_

- [x] 12. Implement email notifications
  - [x] 12.1 Create/update RegistrationConfirmation mailable
    - Include registration number
    - Include payment instructions
    - Include next steps
    - _Requirements: 7.4, 7.5_
  - [x] 12.2 Add email sending with error handling
    - Queue email for async sending
    - Log errors but don't fail registration
    - _Requirements: 7.6_

- [ ]* 12.3 Write property test for email sending resilience
  - **Property 16: Email Sending Resilience**
  - **Validates: Requirements 7.6**

- [x] 13. Implement session management
  - [x] 13.1 Configure session settings
    - Set appropriate session lifetime
    - Use database session driver
    - _Requirements: 8.5_
  - [x] 13.2 Implement session timeout handling
    - Check session validity
    - Redirect with message on expiration
    - _Requirements: 8.6_
  - [x] 13.3 Clear session after successful registration
    - Clear registration session data after success
    - _Requirements: 8.5_

- [ ]* 13.4 Write property test for registration data persistence
  - **Property 14: Registration Data Persistence**
  - **Validates: Requirements 6.1, 6.2, 6.4, 6.5**

- [x] 14. Implement error handling
  - [x] 14.1 Add try-catch in controller methods
    - Handle database errors
    - Handle validation errors
    - _Requirements: 6.6_
  - [x] 14.2 Add database transactions
    - Wrap registration creation in transaction
    - Rollback on failure
    - _Requirements: 6.6_
  - [x] 14.3 Add user-friendly error messages
    - Display Indonesian error messages
    - Log detailed errors for debugging

- [x] 15. Final checkpoint - Complete testing
  - Run all unit tests
  - Run all property-based tests with 100+ iterations
  - Test complete registration flow manually
  - Test "Ubah Data" flow
  - Test "Pindah Jalur" flow
  - Test voucher application
  - Test admin panel functionality
  - Test on mobile devices
  - Ensure all tests pass, ask the user if questions arise.

## Notes

- Tasks marked with `*` are optional and can be skipped for faster MVP
- Each task references specific requirements for traceability
- Checkpoints ensure incremental validation
- Property tests validate universal correctness properties
- Step 4 (Payment) implementation is basic - full payment integration is for later
- UI should match UNPAS design reference
- All user-facing text should be in Indonesian
