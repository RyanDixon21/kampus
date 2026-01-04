# Manual Testing Checklist - STT Pratama Adi Website

## Overview
This document provides a comprehensive manual testing checklist for the university website. Follow each section systematically to ensure all features work correctly.

## Prerequisites
- Application is running locally or on test server
- Database is seeded with sample data
- Admin user credentials are available
- Multiple browsers available for testing (Chrome, Firefox, Safari, Edge)
- Mobile devices or browser dev tools for responsive testing

## 1. Admin Panel Testing

### 1.1 Authentication
- [ ] Navigate to `/admin`
- [ ] Verify redirect to login page if not authenticated
- [ ] Test login with valid credentials (admin@example.com / password)
- [ ] Verify successful login redirects to admin dashboard
- [ ] Test login with invalid credentials
- [ ] Verify error message displays correctly
- [ ] Test logout functionality
- [ ] Verify redirect to login page after logout

### 1.2 Dashboard
- [ ] Verify dashboard loads without errors
- [ ] Check that navigation menu displays all resources:
  - Settings
  - Berita (News)
  - Fasilitas (Facilities)
  - Tendik
  - Pendaftaran (Registrations)
  - Soal CBT (CBT Questions)
- [ ] Verify user profile menu works
- [ ] Test theme toggle (if available)

### 1.3 Settings Management
- [ ] Navigate to Settings menu
- [ ] Verify all sections display:
  - Identitas Kampus (University Identity)
  - Social Media
  - WhatsApp Admin
- [ ] Test updating university name
- [ ] Test logo upload:
  - Upload valid image (JPG/PNG)
  - Verify image preview displays
  - Verify file size validation (max 5MB)
  - Test invalid file type (PDF, TXT)
- [ ] Test updating address, phone, email
- [ ] Test updating social media URLs (Facebook, Instagram, YouTube)
- [ ] Test updating WhatsApp admin number
- [ ] Click Save and verify success message
- [ ] Refresh page and verify changes persisted
- [ ] Verify changes appear on frontend

### 1.4 News Management
- [ ] Navigate to Berita menu
- [ ] Verify news list displays with columns:
  - Thumbnail
  - Title
  - Status
  - Published At
- [ ] Test search functionality
- [ ] Test status filter (Draft/Published)

#### Create News
- [ ] Click "New Berita" button
- [ ] Fill in title
- [ ] Upload thumbnail image
- [ ] Add content using rich text editor:
  - Test bold, italic, underline
  - Test headings
  - Test lists (ordered/unordered)
  - Test links
- [ ] Select status (Draft)
- [ ] Set published date (future date)
- [ ] Click Save
- [ ] Verify success message
- [ ] Verify news appears in list

#### Edit News
- [ ] Click edit on existing news
- [ ] Modify title
- [ ] Change thumbnail
- [ ] Update content
- [ ] Change status to Published
- [ ] Set published date to current date
- [ ] Click Save
- [ ] Verify changes saved

#### Delete News
- [ ] Click delete on a news item
- [ ] Verify confirmation dialog
- [ ] Confirm deletion
- [ ] Verify news removed from list

### 1.5 Facilities Management
- [ ] Navigate to Fasilitas menu
- [ ] Verify facilities list displays

#### Create Facility
- [ ] Click "New Fasilitas"
- [ ] Enter facility name
- [ ] Enter description
- [ ] Upload facility image
- [ ] Set order number
- [ ] Toggle is_active
- [ ] Click Save
- [ ] Verify facility appears in list

#### Reorder Facilities
- [ ] Test drag-and-drop reordering (if available)
- [ ] Or manually change order numbers
- [ ] Verify order changes persist

#### Edit/Delete Facility
- [ ] Test editing facility details
- [ ] Test deleting facility
- [ ] Verify changes reflect on frontend

### 1.6 Tendik Management
- [ ] Navigate to Tendik menu
- [ ] Verify tendik list displays

#### Create Tendik
- [ ] Click "New Tendik"
- [ ] Enter name
- [ ] Enter position
- [ ] Upload photo
- [ ] Enter email
- [ ] Enter phone
- [ ] Toggle is_active
- [ ] Click Save
- [ ] Verify tendik appears in list

#### Edit/Delete Tendik
- [ ] Test editing tendik details
- [ ] Test deleting tendik
- [ ] Verify changes reflect on frontend

### 1.7 Registration Management
- [ ] Navigate to Pendaftaran menu
- [ ] Verify registrations list displays:
  - Registration Number
  - Name
  - Email
  - Status
  - Created At
- [ ] Test search by registration number
- [ ] Test search by name
- [ ] Test status filter

#### View Registration Details
- [ ] Click view on a registration
- [ ] Verify all details display:
  - Data Diri section (Name, Email, Phone, Address)
  - Status section (Registration Number, Status, Payment Status)
- [ ] Verify CBT score displays (if completed)
- [ ] Test delete registration
- [ ] Verify cannot create or edit registrations (read-only)

### 1.8 CBT Questions Management
- [ ] Navigate to Soal CBT menu
- [ ] Verify questions list displays

#### Create CBT Question
- [ ] Click "New Soal CBT"
- [ ] Enter question text
- [ ] Add options using repeater:
  - Add 4-5 options
  - Mark one as correct
  - Verify can add/remove options
- [ ] Select category (Matematika/Bahasa Inggris/Logika)
- [ ] Toggle is_active
- [ ] Click Save
- [ ] Verify question appears in list

#### Edit/Delete Question
- [ ] Test editing question
- [ ] Test deleting question
- [ ] Verify changes work correctly

## 2. Frontend Testing

### 2.1 Homepage
- [ ] Navigate to homepage (`/`)
- [ ] Verify page loads without errors
- [ ] Check all sections display:
  - Hero section with university info
  - Berita section
  - Fasilitas section
  - Tendik section
- [ ] Verify logo displays correctly
- [ ] Verify navigation menu works
- [ ] Test smooth scroll to sections
- [ ] Verify latest news displays (max 6)
- [ ] Verify news thumbnails load
- [ ] Verify facilities display with images
- [ ] Verify tendik display with photos
- [ ] Test clicking news items (if clickable)

### 2.2 Navigation
- [ ] Test all navigation links:
  - Beranda
  - Berita
  - Fasilitas
  - Tendik
  - Pendaftaran
- [ ] Verify smooth scroll animation
- [ ] Test navigation on mobile (hamburger menu)
- [ ] Verify active section highlighting

### 2.3 Responsive Design
#### Desktop (1920x1080)
- [ ] Verify layout looks good
- [ ] Check spacing and alignment
- [ ] Verify images scale properly

#### Tablet (768x1024)
- [ ] Verify responsive layout
- [ ] Check navigation adapts
- [ ] Verify images resize

#### Mobile (375x667)
- [ ] Verify mobile layout
- [ ] Test hamburger menu
- [ ] Verify touch interactions
- [ ] Check text readability
- [ ] Verify images optimize for mobile

### 2.4 Content Display
- [ ] Verify only published news appear
- [ ] Verify draft news do NOT appear
- [ ] Verify future-dated news do NOT appear
- [ ] Verify only active facilities appear
- [ ] Verify only active tendik appear
- [ ] Verify facilities display in correct order
- [ ] Test lazy loading of images (scroll down)

## 3. Registration Flow Testing

### 3.1 Registration Form
- [ ] Navigate to Pendaftaran section
- [ ] Verify form displays with fields:
  - Name
  - Email
  - Phone
  - Address
- [ ] Test form validation:

#### Valid Input
- [ ] Fill all fields with valid data
- [ ] Submit form
- [ ] Verify success and redirect to payment page

#### Invalid Input - Empty Fields
- [ ] Leave name empty, submit
- [ ] Verify error message displays
- [ ] Leave email empty, submit
- [ ] Verify error message displays
- [ ] Leave phone empty, submit
- [ ] Verify error message displays
- [ ] Leave address empty, submit
- [ ] Verify error message displays

#### Invalid Input - Format
- [ ] Enter invalid email (no @)
- [ ] Verify error message
- [ ] Enter invalid phone (wrong format)
- [ ] Verify error message

#### Client-Side Validation
- [ ] Verify validation happens before submission
- [ ] Verify error messages display inline
- [ ] Verify error messages in Bahasa Indonesia

### 3.2 Payment Page
- [ ] After successful registration, verify redirect to payment page
- [ ] Verify registration number displays
- [ ] Verify payment amount displays
- [ ] Verify payment methods display
- [ ] Verify bank account details display
- [ ] Test "Lanjut ke Konfirmasi" button
- [ ] Verify redirect to complete page

### 3.3 Complete Page
- [ ] Verify registration number displays
- [ ] Verify status displays
- [ ] Verify WhatsApp admin number displays
- [ ] Verify pre-filled message template displays
- [ ] Test "Buka WhatsApp" button:
  - Click button
  - Verify WhatsApp opens (web or app)
  - Verify message is pre-filled with:
    - Registration number
    - Name
    - Confirmation text
- [ ] Verify message is URL-encoded correctly

### 3.4 End-to-End Registration
- [ ] Complete full registration flow
- [ ] Verify registration appears in admin panel
- [ ] Verify status is "pending"
- [ ] Verify all data saved correctly
- [ ] Test with multiple registrations
- [ ] Verify each gets unique registration number

## 4. CBT System Testing

### 4.1 CBT Login
- [ ] Navigate to CBT login page
- [ ] Verify form displays

#### Invalid Login
- [ ] Enter non-existent registration number
- [ ] Verify error message
- [ ] Enter registration number with "pending" status
- [ ] Verify error message (must be paid)

#### Valid Login
- [ ] Create registration with "paid" status in admin
- [ ] Enter valid registration number
- [ ] Verify redirect to exam page

### 4.2 CBT Exam Page
- [ ] Verify questions display
- [ ] Verify countdown timer displays and counts down
- [ ] Verify question navigation works:
  - Next question button
  - Previous question button
  - Question number buttons
- [ ] Test selecting answers:
  - Click option A
  - Verify selection highlights
  - Click option B
  - Verify selection changes
- [ ] Verify answered questions marked
- [ ] Test navigating between questions
- [ ] Verify answers persist when navigating

#### Timer Functionality
- [ ] Wait for timer to count down
- [ ] Verify timer updates every second
- [ ] Verify timer shows minutes and seconds
- [ ] Test auto-submit when timer reaches 0:
  - Wait for timer to expire (or set short duration for testing)
  - Verify automatic submission
  - Verify redirect to results page

#### Manual Submit
- [ ] Answer some questions
- [ ] Click submit button
- [ ] Verify confirmation dialog
- [ ] Confirm submission
- [ ] Verify redirect to results page

### 4.3 CBT Results Page
- [ ] Verify score displays
- [ ] Verify score is between 0-100
- [ ] Verify correct calculation:
  - Count correct answers
  - Verify score = (correct/total) × 100
- [ ] Verify result saved in database
- [ ] Check admin panel for updated registration with CBT score

## 5. Cross-Browser Testing

### Chrome
- [ ] Test all features in Chrome
- [ ] Verify no console errors
- [ ] Check responsive design

### Firefox
- [ ] Test all features in Firefox
- [ ] Verify no console errors
- [ ] Check responsive design

### Safari (if available)
- [ ] Test all features in Safari
- [ ] Verify no console errors
- [ ] Check responsive design

### Edge
- [ ] Test all features in Edge
- [ ] Verify no console errors
- [ ] Check responsive design

## 6. Security Testing

### Authentication
- [ ] Verify cannot access admin without login
- [ ] Verify session expires after timeout
- [ ] Verify logout works correctly

### Authorization
- [ ] Create non-admin user (if possible)
- [ ] Verify cannot access admin panel
- [ ] Verify appropriate error message

### CSRF Protection
- [ ] Verify all forms have CSRF token
- [ ] Test form submission without token (should fail)

### Input Sanitization
- [ ] Try entering HTML/JavaScript in text fields
- [ ] Verify output is escaped
- [ ] Verify no XSS vulnerabilities

## 7. Error Handling

### 404 Errors
- [ ] Navigate to non-existent page
- [ ] Verify 404 page displays
- [ ] Verify can navigate back to home

### 500 Errors
- [ ] Test with invalid database connection (if possible)
- [ ] Verify error page displays
- [ ] Verify error is logged

### Validation Errors
- [ ] Verify all validation errors display clearly
- [ ] Verify errors in Bahasa Indonesia
- [ ] Verify errors are user-friendly

## 8. Performance Checks

### Page Load Times
- [ ] Use browser DevTools Network tab
- [ ] Measure homepage load time
- [ ] Verify < 3 seconds on good connection
- [ ] Check admin panel load time

### Image Optimization
- [ ] Verify images are compressed
- [ ] Check image file sizes
- [ ] Verify lazy loading works
- [ ] Test with slow 3G connection

### Database Queries
- [ ] Use Laravel Debugbar (if installed)
- [ ] Check N+1 query issues
- [ ] Verify eager loading is used

## Test Results Summary

### Date: _______________
### Tester: _______________

#### Overall Status
- [ ] All tests passed
- [ ] Some tests failed (document below)
- [ ] Critical issues found

#### Issues Found
1. _______________________________________________
2. _______________________________________________
3. _______________________________________________

#### Notes
_______________________________________________
_______________________________________________
_______________________________________________

## Sign-off
- [ ] All critical features tested and working
- [ ] All issues documented
- [ ] Ready for deployment / Further testing required
