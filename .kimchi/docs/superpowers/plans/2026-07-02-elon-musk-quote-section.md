# Elon Musk Quote Section Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Add a responsive Elon Musk quote section above the footer on the home page.

**Architecture:** Insert a standalone Blade/HTML block into the existing `home.blade.php` before the `<footer>` element. Use existing Tailwind utility classes already present on the page. No new files or assets are needed; the image already exists at `public/img/elon-musk.png`.

**Tech Stack:** Laravel Blade, Tailwind CSS (already loaded in layout).

---

### Task 1: Insert quote section before footer in home.blade.php

**Files:**
- Modify: `resources/views/home.blade.php` (insert before `<footer class="bg-gray-900 py-10">`)
- Test: Visual verification in browser

- [ ] **Step 1: Locate the footer insertion point**

Open `resources/views/home.blade.php` and find the line:

```html
<footer class="bg-gray-900 py-10">
```

- [ ] **Step 2: Insert the quote section block**

Insert the following block immediately **before** the `<footer>` opening tag:

```html
<section class="bg-white py-16 md:py-20">
  <div class="container mx-auto px-6">
    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
      <div class="grid grid-cols-1 md:grid-cols-2">
        <div class="h-64 md:h-auto">
          <img src="{{ asset('img/elon-musk.png') }}" alt="Elon Musk" class="w-full h-full object-cover object-center">
        </div>
        <div class="p-8 md:p-12 flex flex-col justify-center">
          <div class="text-red-600 text-6xl leading-none font-serif mb-4">"</div>
          <blockquote class="text-xl md:text-2xl font-medium text-gray-900 leading-relaxed">
            When something is important enough, you do it even if the odds are not in your favor.
          </blockquote>
          <p class="text-gray-500 font-semibold mt-4">— Elon Musk</p>
        </div>
      </div>
    </div>
  </div>
</section>
```

- [ ] **Step 3: Verify the edit did not break component structure**

Run:

```bash
php artisan view:cache
```

Expected: Command completes without the previous "Unable to locate a class or view for component [layouts.app]" error. (Note: this WSL environment may still fail on `DOMDocument` because the `php-dom` extension is missing; that is an environment issue, not a code issue.)

- [ ] **Step 4: Validate HTML structure**

Open `resources/views/home.blade.php` and confirm:
- The new `<section>` is directly inside the root `<div class="min-h-screen bg-white">` and before `<footer>`.
- The new block opens with `<section>` and closes with `</section>`.
- No unmatched tags were introduced inside or around the insertion.

- [ ] **Step 5: Visual verification in Herd**

Open the site in the Herd environment (where PHP extensions are complete) and:
- Scroll to the bottom of the home page.
- Confirm the Elon Musk image appears on the left and the quote on the right (desktop).
- Resize to mobile width and confirm the image stacks above the quote.
- Confirm the section sits directly above the footer.

- [ ] **Step 6: Commit**

```bash
git add resources/views/home.blade.php
git commit -m "feat: add Elon Musk quote section above footer"
```

---

## Self-Review

**Spec coverage:**
- Standalone section above footer → Task 1, Step 2.
- Uses `public/img/elon-musk.png` → Task 1, Step 2 (`{{ asset('img/elon-musk.png') }}`).
- Displays default quote + attribution → Task 1, Step 2.
- Responsive layout → Task 1, Step 2 (`grid-cols-1 md:grid-cols-2`, stacked image).
- Matches existing light-card design language → Task 1, Step 2 (`bg-white rounded-2xl shadow-lg border border-gray-100`).

**Placeholder scan:** No TBD/TODO placeholders. All code is explicit.

**Type consistency:** N/A — only static Blade/HTML.
