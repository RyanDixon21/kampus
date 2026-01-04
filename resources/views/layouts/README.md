# App Layout Documentation

## Overview
This layout file (`app.blade.php`) provides the main structure for the STT Pratama Adi university website.

## Features Implemented

### 1. Tailwind CSS Integration
- ✅ Tailwind CSS 3.4.0 configured with custom blue theme
- ✅ Custom primary color palette (blue shades)
- ✅ PostCSS and Autoprefixer configured
- ✅ Vite build system integrated

### 2. Logo Integration
- ✅ STT Pratama Adi logo displayed in navigation
- ✅ Logo displayed in footer
- ✅ Responsive logo sizing

### 3. Navigation Menu
- ✅ Desktop navigation with links to:
  - Beranda (Home)
  - Berita (News)
  - Fasilitas (Facilities)
  - Tendik (Staff)
  - Pendaftaran (Registration) - highlighted as CTA button
- ✅ Mobile responsive hamburger menu
- ✅ Active state tracking with Alpine.js
- ✅ Smooth transitions and animations

### 4. Smooth Scroll Navigation
- ✅ HTML scroll-behavior: smooth enabled
- ✅ Single-page navigation with anchor links
- ✅ Smooth scrolling to sections

### 5. Responsive Design
- ✅ Mobile-first approach
- ✅ Breakpoints: sm (640px), md (768px), lg (1024px)
- ✅ Responsive navigation (hamburger menu on mobile)
- ✅ Responsive grid layouts
- ✅ Responsive typography

### 6. Alpine.js Integration
- ✅ Alpine.js 3.13.3 for interactive components
- ✅ Mobile menu toggle
- ✅ Active section tracking
- ✅ Scroll-to-top button with show/hide animation

### 7. Footer
- ✅ Three-column layout (About, Contact, Social Media)
- ✅ Dynamic content from settings
- ✅ Contact information display
- ✅ Social media links (Facebook, Instagram, YouTube)
- ✅ Copyright notice

### 8. Additional Features
- ✅ Scroll-to-top button (appears after scrolling 300px)
- ✅ Smooth animations and transitions
- ✅ Custom CSS animations (fadeIn)
- ✅ Loading indicators support via @stack('scripts')

## Theme Colors

Primary Blue Palette:
- 50: #eff6ff (lightest)
- 100: #dbeafe
- 200: #bfdbfe
- 300: #93c5fd
- 400: #60a5fa
- 500: #3b82f6
- 600: #2563eb (primary)
- 700: #1d4ed8
- 800: #1e40af
- 900: #1e3a8a
- 950: #172554 (darkest)

## Requirements Validated

✅ Requirement 2.1: Frontend displays homepage with blue theme matching logo
✅ Requirement 2.2: Logo displayed on all pages
✅ Requirement 2.3: Navigation menu for Beranda, Berita, Fasilitas, Tendik, Pendaftaran
✅ Requirement 2.4: Single page navigation with smooth scroll
✅ Requirement 2.8: Responsive design for desktop and mobile
✅ Requirement 10.1: Blue theme matching STT Pratama Adi branding
✅ Requirement 10.2: Responsive navigation
✅ Requirement 10.3: Modern CSS framework (Tailwind CSS)

## Usage

To use this layout in a view:

```blade
@extends('layouts.app')

@section('content')
    <!-- Your page content here -->
@endsection
```

To add custom scripts:

```blade
@push('scripts')
    <script>
        // Your custom JavaScript
    </script>
@endpush
```

## Testing

Run the layout tests:
```bash
php artisan test --filter=LayoutTest
```

## Build Assets

Development:
```bash
npm run dev
```

Production:
```bash
npm run build
```
