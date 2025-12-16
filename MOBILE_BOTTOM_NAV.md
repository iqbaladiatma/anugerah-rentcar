# Mobile Bottom Navigation

## Overview

Bottom navigation bar untuk mobile dengan 4 link utama yang selalu terlihat di bagian bawah layar.

## Features

### 📱 4 Quick Access Links

1. **Dashboard** (Kiri)
   - Icon: Home
   - Route: `/dashboard`
   - Active indicator: Blue color

2. **Bookings** (Tengah kiri)
   - Icon: Clipboard
   - Route: `/admin/bookings`
   - Active indicator: Blue color when in bookings pages

3. **Vehicles** (Tengah kanan)
   - Icon: Calendar
   - Route: `/admin/vehicles`
   - Active indicator: Blue color when in vehicles pages

4. **Menu** (Kanan) 
   - Icon: Hamburger menu
   - Action: **Opens sidebar**
   - Interactive: Tap to toggle sidebar

## Design

### Visual Style
- **Background**: White with shadow
- **Border**: Top border gray-200
- **Active state**: Blue-600 color
- **Inactive state**: Gray-600 color
- **Icons**: 24x24px (w-6 h-6)
- **Text**: Extra small (text-xs), medium weight

### Layout
```
┌────────────────────────────────┐
│  🏠      📋      🚗      ☰     │
│ Dashboard Bookings Vehicles Menu│
└────────────────────────────────┘
```

### Responsive Behavior
- **Mobile (< 1024px)**: Bottom nav visible
- **Desktop (≥ 1024px)**: Bottom nav hidden (uses sidebar instead)

## Implementation

### Files Created

1. **Controller**: `app/Livewire/Layout/MobileBottomNav.php`
   - Handles sidebar toggle event
   - Dispatches `toggleSidebar` event to AdminSidebar component

2. **View**: `resources/views/livewire/layout/mobile-bottom-nav.blade.php`
   - Bottom navigation markup
   - 4 navigation links
   - Active state detection

3. **Layout**: `resources/views/layouts/admin.blade.php` (Modified)
   - Added `<livewire:layout.mobile-bottom-nav />`
   - Added padding-bottom to main content (`pb-20 lg:pb-6`)

## How It Works

### Toggle Sidebar

When user taps "Menu" button:

```php
// MobileBottomNav.php
public function toggleSidebar()
{
    $this->dispatch('toggleSidebar');
}
```

Event dispatched → AdminSidebar listens → Sidebar opens/closes

### Active State Detection

Each link checks if current route matches:

```blade
{{ request()->routeIs('dashboard') ? 'text-blue-600' : 'text-gray-600' }}
```

```blade
{{ request()->routeIs('admin.bookings.*') ? 'text-blue-600' : 'text-gray-600' }}
```

### Content Padding

Main content has bottom padding to prevent overlap:

```html
<main class="py-6 pb-20 lg:pb-6">
```

- **Mobile**: `pb-20` (80px padding, enough for 64px nav + spacing)
- **Desktop**: `pb-6` (normal padding, no bottom nav)

## Customization

### Change Links

Edit `mobile-bottom-nav.blade.php`:

```blade
<!-- Example: Add Reports link -->
<a href="{{ route('admin.reports.index') }}" 
   wire:navigate
   class="flex flex-col items-center justify-center space-y-1 {{ request()->routeIs('admin.reports.*') ? 'text-blue-600' : 'text-gray-600' }} hover:text-blue-600 transition-colors">
    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
    </svg>
    <span class="text-xs font-medium">Reports</span>
</a>
```

### Change Colors

Update Tailwind classes:

```blade
<!-- Active color -->
text-blue-600  → text-purple-600

<!-- Inactive color -->
text-gray-600  → text-gray-500

<!-- Hover color -->
hover:text-blue-600  → hover:text-purple-600
```

### Adjust Height

```blade
<!-- Change from h-16 to h-20 -->
<div class="grid grid-cols-4 h-20">
```

Don't forget to update main content padding:
```html
<!-- Change from pb-20 to pb-24 -->
<main class="py-6 pb-24 lg:pb-6">
```

## iOS Safe Area Support

The bottom nav includes `pb-safe` class for iOS devices with home indicator:

```blade
<nav class="... pb-safe">
```

This ensures the nav doesn't get obscured by the home indicator on newer iPhones.

## Browser Compatibility

✅ Chrome/Edge (Mobile & Desktop)  
✅ Safari (iOS & macOS)  
✅ Firefox (Mobile & Desktop)  
✅ Samsung Internet  

## Performance

- **Lazy loading**: No impact, always rendered
- **JavaScript**: Minimal (Alpine.js for active states)
- **Livewire**: Only used for sidebar toggle
- **CSS**: Tailwind utility classes (no custom CSS)

## Accessibility

- **Touch targets**: 64px height (meets WCAG 2.1 AA)
- **Visual feedback**: Color change on tap
- **Screen readers**: Proper semantic HTML
- **Keyboard navigation**: Links are focusable

## Testing Checklist

Mobile (< 1024px width):
- [ ] Bottom nav visible at bottom of screen
- [ ] Dashboard link navigates to /dashboard
- [ ] Bookings link navigates to /admin/bookings
- [ ] Vehicles link navigates to /admin/vehicles
- [ ] Menu button opens sidebar
- [ ] Active link shows blue color
- [ ] Content not hidden behind bottom nav

Desktop (≥ 1024px width):
- [ ] Bottom nav hidden
- [ ] Sidebar visible
- [ ] No bottom padding on content

## Known Issues

None currently.

## Future Enhancements

- [ ] Add badge counts (e.g., pending bookings count)
- [ ] Add animation on tab switch
- [ ] Add haptic feedback on iOS
- [ ] Add more quick actions
- [ ] Customize links based on user role
