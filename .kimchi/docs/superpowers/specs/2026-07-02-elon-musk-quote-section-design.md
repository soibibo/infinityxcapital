# Elon Musk Quote Section — Design Spec

## Overview
Add a standalone quote section near the bottom of the home page, just above the footer, featuring `public/img/elon-musk.png` and a quote attributed to Elon Musk.

## Placement
Insert the new section immediately before the `<footer>` element in `resources/views/home.blade.php`, after the live transactions/social-proof section.

## Visual Design

### Container
- Full-width section with `bg-white` background.
- Vertical padding: `py-16 md:py-20`.
- Inner container: `container mx-auto px-6`.

### Card
- White card: `bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden`.
- Responsive layout:
  - Desktop (`md:` and up): two-column grid, image on left, quote on right.
  - Mobile: stacked, image on top.

### Image
- Source: `{{ asset('img/elon-musk.png') }}`.
- Treatment: full height of the card on desktop, `object-cover object-center`.
- Mobile: `h-64 w-full` or similar, with rounded top corners inherited from card.

### Quote Block
- Large decorative quotation mark in `text-red-600` / `text-red-500`.
- Quote text: `text-xl md:text-2xl font-medium text-gray-900 leading-relaxed`.
- Attribution: `text-gray-500 font-semibold mt-4` — "— Elon Musk".
- Padding: `p-8 md:p-12`.

### Copy
- **Quote:** "When something is important enough, you do it even if the odds are not in your favor."
- **Attribution:** Elon Musk

## Technical Details
- Implementation is a static Blade/HTML block inside `home.blade.php`.
- No new CSS file; use existing Tailwind utility classes already present on the page.
- No JavaScript required.

## Acceptance Criteria
- [ ] A standalone quote section appears above the footer on `/`.
- [ ] The section displays `public/img/elon-musk.png`.
- [ ] The section displays the Elon Musk quote and attribution.
- [ ] Layout is responsive (stacked on mobile, side-by-side on desktop).
- [ ] Visual style matches the existing light-card design language of the page.
