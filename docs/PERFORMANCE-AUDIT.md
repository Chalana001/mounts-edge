# Mounts Edge Regency — Site Performance & Image Loading Audit

> **Status: Phases 1–5 complete (2026-08-26).** Image library 61.6 MB → 12.5 MB.
> Home page initial load 23.9 MB → **575 KB** (a 97.6% reduction). JS bundle
> 84.6 KB → 47.8 KB. Uploads are optimised automatically and WebP is served
> wherever it wins. See the completed-phase sections at the end of this document,
> and `DEPLOYMENT.md` for the release checklist. No duplicate images remain.
> Sections 1–5 below describe the state *before* those changes and are kept as
> the baseline record.

**Date:** 2026-08-26
**Scope:** Full public site (`/`, `/luxury-stay`, `/weddings`, `/dining`, `/experiences`, `/gallery`, `/contact`) + admin
**Method:** Static analysis of Blade views, Vite build output, `storage/app/public` image inventory (78 files), controllers, and server config.

---

## 1. Executive summary

The site's code is lean — the JS/CSS bundle is **147 KB total**, there are no N+1 query problems, and Alpine is used sparingly. **Performance is almost entirely an image problem.**

| Metric | Current | Healthy target |
|---|---|---|
| Home page image payload | **23.9 MB** | < 1.5 MB |
| Largest single image | **4.2 MB** (2048×2048) | < 200 KB |
| Images over 1 MB | **21 of 78** | 0 |
| Total image library | **61.6 MB** | ~6–8 MB |
| Duplicate bytes on disk | **22.7 MB** | 0 |
| `<img>` tags with `loading="lazy"` | **4 of 25** | all below-fold |
| `<img>` tags with `width`/`height` | **0 of 25** | all |
| `srcset` / responsive images | **0** | all content images |
| Modern formats (WebP/AVIF) | **1 file** | all |
| Static asset cache headers | **none** | 1 year, immutable |
| JS + CSS bundle | 147 KB | OK |

**Estimated impact:** on a typical Sri Lankan 4G connection (~5 Mbps), the home page currently needs roughly **35–40 seconds** to finish loading images. Largest Contentful Paint is likely **8–15 s**. After the fixes in Section 6, the same page should land at **~800 KB and 2–3 s**.

---

## 2. Image inventory — the core problem

### 2.1 Oversized source files

Twenty-one images exceed 1 MB. Nineteen of them are **2048×2048** — square masters exported straight from the camera/editor with no compression pass, then displayed in containers that are often a fraction of that size.

| Size | Dimensions | File | Displayed at |
|---|---|---|---|
| 4,216 KB | 2048×2048 | `home/signature-moments/pool.jpg` | ~300×400 card |
| 4,216 KB | 2048×2048 | `home/pool-highlight.jpg` | section bg |
| 4,216 KB | 2048×2048 | `gallery/pool1.jpg` | masonry tile |
| 3,457 KB | 2048×2048 | `hero-images/experience.jpg` | page hero |
| 3,457 KB | 2048×2048 | `experiences/attractions/paragliding.jpg` | card |
| 3,038 KB | 2048×2048 | `home/signature-moments/sunrise.jpg` | ~300×400 card |
| 3,038 KB | 2048×2048 | `gallery/nature1.jpg` | masonry tile |
| 2,452 KB | 2048×2048 | `home/hero/luxury-suites.jpg` | full-bleed hero |
| 2,452 KB | 2048×2048 | `hero-images/stay.jpg` | page hero |
| 2,346 KB | 2048×2048 | `home/hero/nature-trails.jpg` | full-bleed hero |
| 2,334 KB | 2048×2048 | `gallery/nature2.jpg` | masonry tile |
| 2,200 KB | 2048×2048 | `home/hero/pool4.jpg` | full-bleed hero |
| 2,200 KB | 2048×2048 | `gallery/pool2.jpg` | masonry tile |
| 2,173 KB | 2048×2048 | `home/signature-moments/celebration.jpg` | ~300×400 card |
| 1,917 KB | 2048×2048 | `weddings/highlights/1.jpg` | photo-spot tile |
| 1,738 KB | 2048×2048 | `gallery/room3.jpg` | masonry tile |
| 1,700 KB | 2048×2048 | `rooms/Ra5CmU….jpg` | room card |
| 1,700 KB | 2048×2048 | `experiences/nearby-highlights/victoria-dam.jpg` | card |
| 1,674 KB | 2048×2048 | `home/experiences/stay.jpg` | section bg |
| 1,214 KB | 2048×1365 | `home/experiences/weddings.jpg` | section bg |
| 1,214 KB | 2048×1365 | `hero-images/weddings.jpg` | page hero |

A 2048×2048 photo re-encoded at quality 78 and resized to what the layout actually needs typically lands at **60–150 KB** — a **95–97 % reduction** with no visible difference.

Two more outliers worth naming:

- `experiences/attractions/bbq-night.png` — **668 KB as a 720×480 PNG**. A photograph stored as PNG. As JPEG/WebP it would be ~40 KB.
- `experiences/nearby-highlights/18-bends.jpg` — **641 KB for only 864×576**. Badly over-encoded for its dimensions.

### 2.2 Duplicate files — 22.7 MB wasted

The same photo has been uploaded multiple times under different names. Each copy is a separate URL, so the browser downloads and caches it **separately** — a visitor going Home → Gallery re-downloads 4.2 MB of pool photo they already have.

| Wasted | Copies |
|---|---|
| 8.2 MB | `gallery/pool1.jpg` = `home/pool-highlight.jpg` = `home/signature-moments/pool.jpg` (×3) |
| 3.4 MB | `experiences/attractions/paragliding.jpg` = `hero-images/experience.jpg` |
| 3.0 MB | `gallery/nature1.jpg` = `home/signature-moments/sunrise.jpg` |
| 2.4 MB | `hero-images/stay.jpg` = `home/hero/luxury-suites.jpg` |
| 2.1 MB | `gallery/pool2.jpg` = `home/hero/pool4.jpg` |
| 1.7 MB | `experiences/nearby-highlights/victoria-dam.jpg` = `rooms/Ra5CmU….jpg` |
| 1.2 MB | `hero-images/weddings.jpg` = `home/experiences/weddings.jpg` |
| 0.4 MB | `weddings/outdoor-hall.jpg` = `weddings/3tKybP….jpg` |
| 0.3 MB | `home/mounts-edge-regency.jpg` = `home/hero/mounts-edge-regency.jpg`, `gallery/room1.jpg` = `rooms/QN3hIo….jpg` |

### 2.3 Format

Of 78 files: 74 JPEG, 2 PNG, 1 WebP, 1 `.jfif`. Effectively **zero modern-format adoption**. WebP saves ~30 % over an equivalently-tuned JPEG; AVIF saves ~50 %.

Note also `dining/bar.jfif` — `.jfif` is valid JPEG but some CDNs and older tooling mis-handle the extension. Rename to `.jpg`.

---

## 3. Loading strategy — page by page

### 3.1 Home page — 23.9 MB, essentially all of it eager

`resources/views/welcome.blade.php` composes eight sections. Image weight:

| Section | Images | Weight | Loading behaviour |
|---|---|---|---|
| Hero carousel | 6 | **7.64 MB** | **All 6 load immediately** |
| Experience section | 2 | 2.82 MB | eager CSS background |
| Signature moments | 4 | 9.33 MB | eager CSS background |
| Pool highlight | 1 | 4.12 MB | eager |
| **Total** | **13** | **23.90 MB** | — |

**The hero is the single worst offender.** In `resources/views/components/home/hero-section.blade.php`:

```blade
<template x-for="slide in slides" :key="'bg-'+slide.id">
    <div class="absolute inset-0 bg-cover bg-center …"
         :style="`background-image: url('${slide.image}');`">
```

Alpine renders a `<div>` for **all six slides at once** — five of them at `opacity-0`, but the browser still fetches every background image because the element is in the DOM and painted. Below that, the thumbnail strip does the same again:

```blade
<img :src="slide.image" class="absolute inset-0 w-full h-full object-cover" alt="thumbnail" />
```

Six **full-resolution 2048×2048 originals** — up to 2.4 MB each — are being used as **~120×186 px thumbnails**. That is roughly a 280× oversupply of pixels. (They share URLs with the backgrounds, so the browser fetches each once, but the 7.6 MB is still all on the critical path.)

`signature-moments.blade.php` is the same shape: four 3/4-aspect cards, roughly 300 px wide, each backed by a 2–4 MB square master, all eager because CSS `background-image` has no lazy-loading equivalent.

### 3.2 Other pages

| Page | Images from views | Weight | Notes |
|---|---|---|---|
| `/experiences` | 1 hero + DB cards | 3.38 MB + | hero alone is 3.4 MB |
| `/weddings` | 5 | 4.31 MB | `highlights/1.jpg` is 1.9 MB |
| `/luxury-stay` | 1 hero + DB rooms | 2.40 MB + | room images up to 1.7 MB |
| `/gallery` | 12 DB items | ~14 MB folder | *has* `loading="lazy"` + `decoding="async"` |
| `/dining` | DB-driven | — | `bar.jfif` 273 KB bg |
| `/contact` | 0 | — | map iframe is lazy |

The gallery grid is the **one place done right** (`components/gallery/grid.blade.php:73`) — but it still serves full-size masters into a masonry column ~300 px wide, and the lightbox array (`$lightboxItems`) is JSON-embedded into the page for all 12 items.

### 3.3 Missing attributes across the whole site

| Attribute | Present | Missing | Consequence |
|---|---|---|---|
| `loading="lazy"` | 4 | 21 | Below-fold images block the connection |
| `width` / `height` | 0 | 25 | **Cumulative Layout Shift** on every image |
| `srcset` / `sizes` | 0 | 25 | Mobile downloads desktop-sized files |
| `fetchpriority="high"` | 0 | — | Browser can't prioritise the LCP image |
| `decoding="async"` | 2 | 23 | Main-thread decode jank on large JPEGs |
| `<link rel="preload">` for LCP | 0 | — | Hero image discovered late (it's set by JS) |

The missing `width`/`height` is worth calling out separately: with no intrinsic size, the browser reserves zero space, then reflows the whole page when each photo arrives. On a 24 MB home page arriving over seconds, that produces continuous layout shift — a direct Core Web Vitals failure.

---

## 4. Delivery & server configuration

### 4.1 No cache headers — every visit re-downloads everything

`public/.htaccess` contains only Laravel's default rewrite rules. There is **no `mod_expires` or `mod_deflate` block**. Without `Cache-Control`/`Expires`, Apache falls back to conditional revalidation at best — and for a returning visitor that means re-fetching 24 MB.

This is the **highest-leverage single fix in the entire audit** and takes ten lines of config.

### 4.2 Local/dev config in place

```
APP_ENV=local
APP_DEBUG=true      <- must be false in production
LOG_LEVEL=debug     <- should be 'error'
CACHE_DRIVER=file
SESSION_DRIVER=file
```

With `APP_DEBUG=true`, Laravel loads the full error handler, collects query/exception traces, and skips several optimisations. It is also a **security exposure** — stack traces leak paths, env values, and DB structure.

`bootstrap/cache/` holds only `packages.php` and `services.php` — **no `config.php` or `routes-v7.php`**, so `php artisan config:cache` / `route:cache` / `view:cache` have not been run. On this app that costs roughly 20–40 ms per request.

### 4.3 No image processing pipeline

`composer.json` has no `intervention/image`, `spatie/laravel-image-optimizer`, or Glide. Uploads are stored raw:

```php
// AdminGalleryController.php:52
$imagePath = $request->file('image')->store('gallery', 'public');
```

So **every future admin upload reintroduces this problem.** Optimising today's 78 files is a one-time cleanup; without a pipeline the library drifts straight back to multi-megabyte originals.

### 4.4 Bundle — no action needed

| Asset | Size |
|---|---|
| `app-44d55497.js` | 84.5 KB |
| `app-e2fb682c.css` | 66.4 KB |
| **Total** | **147 KB** |

This is healthy. Tailwind is purging correctly (66 KB, not 3 MB). The only trim available: `resources/js/bootstrap.js` imports **axios** (~35 KB of the 84 KB) and nothing in the codebase ever calls it. All forms are standard POSTs. Removing it cuts the JS bundle by roughly 40 %.

Google Fonts is loaded via a render-blocking `<link>` in `layouts/app.blade.php`. `preconnect` is correctly set, and `display=swap` is present, so this is acceptable — but self-hosting the two families (Playfair Display, Lato) would remove a third-party round-trip from the critical path.

### 4.5 Database — clean

No N+1 problems found. `GalleryController` uses `with('category')`; `RoomController` uses `with(['rooms.features'])`; `WeddingController` runs four simple queries. SQLite with these row counts (12 gallery items, 4 rooms, 2 halls) is not a bottleneck.

---

## 5. Root causes, ranked by impact

1. **Source images were never processed** — 2048×2048 masters uploaded raw. Accounts for ~90 % of total page weight.
2. **No cache headers** — every visit pays the full cost again.
3. **Hero renders all six slides simultaneously** — 7.6 MB on the critical path for one visible image.
4. **CSS `background-image` used for below-fold sections** — cannot be lazy-loaded; forces ~16 MB eager on the home page.
5. **Full-size masters used as thumbnails** — up to 280× more pixels than displayed.
6. **Duplicate uploads** — 22.7 MB of redundant bytes, and no cross-page cache reuse.
7. **No `width`/`height`** — layout shift throughout.
8. **No upload-time optimisation** — the problem regenerates itself.

---

## 6. Recommended fixes, in order

### Phase 1 — one-time wins (~1 day, ~92 % payload reduction)

**1.1 Add cache + compression headers** to `public/.htaccess`:

```apache
<IfModule mod_expires.c>
    ExpiresActive On
    ExpiresByType image/jpeg "access plus 1 year"
    ExpiresByType image/png  "access plus 1 year"
    ExpiresByType image/webp "access plus 1 year"
    ExpiresByType image/avif "access plus 1 year"
    ExpiresByType image/svg+xml "access plus 1 year"
    ExpiresByType text/css   "access plus 1 year"
    ExpiresByType application/javascript "access plus 1 year"
</IfModule>
<IfModule mod_headers.c>
    <FilesMatch "\.(jpg|jpeg|png|webp|avif|svg|css|js|woff2)$">
        Header set Cache-Control "public, max-age=31536000, immutable"
    </FilesMatch>
</IfModule>
<IfModule mod_deflate.c>
    AddOutputFilterByType DEFLATE text/html text/css application/javascript application/json image/svg+xml
</IfModule>
```

Vite already fingerprints CSS/JS filenames, so `immutable` is safe for those. Image filenames are not fingerprinted — a changed photo needs a new filename or a `?v=` query.

**1.2 Batch-resize and re-encode all 78 images.** Target maximum dimensions by role:

| Role | Max width | Format | Expected size |
|---|---|---|---|
| Full-bleed hero | 1920 | WebP q80 | 150–250 KB |
| Section background | 1600 | WebP q80 | 100–180 KB |
| Gallery / card | 1200 | WebP q80 | 60–120 KB |
| Thumbnail (hero strip) | 400 | WebP q75 | 15–30 KB |

Keep a `.jpg` fallback alongside each `.webp` and serve with `<picture>`, or use WebP alone — browser support is now universal for the site's audience.

**1.3 De-duplicate.** Pick one canonical path per photo and update the three or four references. Removes 22.7 MB and lets a visitor's cache carry across pages.

**1.4 Convert `bbq-night.png` to WebP** (668 KB → ~40 KB) and rename `bar.jfif` → `bar.jpg`.

### Phase 2 — loading behaviour (~half a day)

**2.1 Fix the hero.** Render only the active background plus the next one:

```blade
<template x-for="slide in slides" :key="'bg-'+slide.id">
    <div x-show="slide.id === activeBg.id || slide.id === nextBg.id" …>
```

Add a separate small thumbnail file per slide (a `thumb` key alongside `image` in `slidesData`) so the strip pulls 20 KB files instead of 2.4 MB masters. Add `loading="lazy"` to the thumbnail `<img>`.

**2.2 Preload the LCP image.** The first hero background is set by Alpine after JS parses, so the browser discovers it late. Add to `layouts/app.blade.php`:

```blade
<link rel="preload" as="image" href="/storage/home/hero/mounts-edge-regency.webp" fetchpriority="high">
```

**2.3 Convert below-fold CSS backgrounds to `<img>`.** `signature-moments`, `experience-section`, `pool-highlight`, and `photo-spots` all use `background-image`, which cannot be lazy-loaded. Switch to an absolutely-positioned `<img class="object-cover" loading="lazy" decoding="async">` — same visual result, but the browser can defer it. This alone removes ~16 MB from the home page's critical path.

**2.4 Add `width` and `height` to every `<img>`** to eliminate layout shift. For `object-cover` images the intrinsic ratio is what matters — pass the real pixel dimensions and let CSS size it.

**2.5 Add `srcset`/`sizes`** to content images so phones fetch ~600 px files instead of 1600 px ones. Roughly halves mobile payload again.

### Phase 3 — prevent regression (~half a day)

**3.1 Install `spatie/laravel-image-optimizer` or `intervention/image`** and process on upload:

```bash
composer require intervention/image
```

Resize to a max dimension (e.g. 1920), re-encode to WebP q80, and store that — in `AdminGalleryController::store`, `AdminRoomController`, and `AdminWeddingController::storeHall`. Generate a thumbnail variant at the same time.

**3.2 Production env:**

```
APP_ENV=production
APP_DEBUG=false
LOG_LEVEL=error
```

**3.3 Run the optimisation commands on deploy:**

```bash
php artisan config:cache && php artisan route:cache && php artisan view:cache
```

**3.4 Remove axios** from `resources/js/bootstrap.js` — unused, ~35 KB of the 84 KB JS bundle.

**3.5 Consider self-hosting the two Google Fonts** to drop a third-party connection from the critical path.

---

## 7. Projected result

| | Before | After Phase 1 | After Phase 2 |
|---|---|---|---|
| Home page images | 23.9 MB | ~2.2 MB | **~0.8 MB** (rest lazy) |
| Largest image | 4.2 MB | ~220 KB | ~220 KB |
| JS + CSS | 147 KB | 147 KB | ~112 KB |
| Repeat visit | full re-download | ~0 KB | ~0 KB |
| Est. LCP (4G) | 8–15 s | 2.5–4 s | **1.5–2.5 s** |
| Total library | 61.6 MB | ~7 MB | ~7 MB |

Phase 1 alone — image compression plus cache headers — delivers roughly **90 % of the total benefit** and touches no application logic.

---

## 8. What is already good

- JS/CSS bundle at 147 KB with Tailwind purging correctly.
- No N+1 queries; eager loading used properly in all three public controllers.
- Alpine `x-intersect` used to gate reveal animations and to stop slider timers when off-screen (`resources/js/app.js`) — genuinely good practice.
- `prefers-reduced-motion` respected in the count-up animation.
- Gallery grid already uses `loading="lazy"` + `decoding="async"`.
- Contact map iframe is lazy-loaded.
- Fonts use `preconnect` + `display=swap`.
- Skip-to-content link and `aria-live` region present — accessibility was clearly considered.

The engineering here is careful. The gap is purely in the asset pipeline, which never existed.

---

## Phase 1 — completed

Done on 2026-08-26. No application logic was touched; no Blade reference, seeder,
or database row changed, with one deliberate exception noted below.

### What changed

**Originals backed up** to `storage/app/image-originals/` (62 MB, all 77 files
verified byte-identical by MD5). That path is gitignored, so it stays local and
never reaches the repo or a deploy. Revert everything with:

```bash
php scripts/optimize-images.php --restore
```

**All 77 images re-encoded in place** via the new `scripts/optimize-images.php`,
keeping every filename and extension. Sizes were capped by measured display role
rather than one blanket number — a signature-moments card renders ~270 px wide
in a `max-w-6xl` 4-column grid, so it does not need a 1600 px master:

| Role | Cap | Quality |
|---|---|---|
| Full-bleed / page hero | 1600 | 78 |
| Section background | 1600 | 78 |
| Gallery (sized for the lightbox, not the tile) | 1500 | 78 |
| Hall slider | 1500 | 78 |
| Room card | 1400 | 78 |
| Dining card | 1400 | 78 |
| Inline card (e.g. pool-highlight) | 1200 | 78 |
| Experience card / photo-spot tile | 1200 | 78 |
| Moment card | 800 | 78 |

JPEGs are written progressive. The script refuses to write a file that would
come out larger, restoring the original instead — 20 already-tuned images were
skipped on that rule.

**`bbq-night.png` → `bbq-night.jpg`** (667 KB → 91 KB, 86 %). A photograph stored
as PNG, which GD could not meaningfully compress. This is the one reference
change in Phase 1: `components/experiences/attractions.blade.php:31`. Verified
no dangling references remain.

**Cache and compression headers added** to `public/.htaccess` — there were none
at all before. Vite's content-hashed `/build` assets are marked `immutable`;
images get a one-year `max-age` without `immutable`, since their filenames are
not fingerprinted. HTML is explicitly `no-cache`. Only text types are DEFLATE'd.

### Results

| | Before | After | Saved |
|---|---|---|---|
| Total image library | 61.0 MB | **12.5 MB** | 79.6 % |
| Home page (measured live) | 23.9 MB | **3.31 MB** | 86 % |
| Largest single file | 4.2 MB | **508 KB** | 88 % |
| Files over 1 MB | 21 | **0** | — |
| `/weddings` | 4.31 MB | 1.22 MB | 72 % |
| `/experiences` | 3.38 MB | 0.48 MB | 86 % |
| `/luxury-stay` | 2.40 MB | 0.33 MB | 86 % |
| Repeat visit | full re-download | ~0 KB | — |

### Verification

- All 77 files decode cleanly (`getimagesize` on every one; 0 corrupt).
- No EXIF orientation tag other than 1 anywhere in the set, so re-encoding could
  not silently rotate a photo. The script checks this per file and skips any it
  finds rather than guessing.
- Every public page rendered in a browser with **zero broken images**: home (9),
  gallery (14), luxury-stay (8), weddings (7), dining (7), contact (2),
  experiences. No console errors. All `/storage/` requests returned 200.

### Caveats

- **Deploying these images is a manual step — `git push` will not do it.**
  `storage/app/public/.gitignore` contains `*`, so none of the 77 images are
  tracked by git; only `.gitignore` itself is. The optimised files currently
  exist on the dev machine alone. To get them live, either copy
  `storage/app/public/` to the server directly (rsync/SFTP), or copy
  `scripts/optimize-images.php` up and run it there against the production
  images — the script is idempotent and backs up before writing, so running it
  on the server is safe. Whichever route, the `public/storage` symlink must
  exist (`php artisan storage:link`).
- **The `.htaccess` headers are unverified locally.** `php artisan serve` uses
  PHP's built-in server, which ignores `.htaccess` entirely. They take effect
  only on Apache — confirm on staging with
  `curl -I https://<host>/storage/home/hero/pool4.jpg` and look for
  `Cache-Control: public, max-age=31536000`. On nginx these rules do nothing and
  the equivalent `location` block is needed instead.
- `mod_expires`, `mod_headers`, and `mod_deflate` must be enabled on the host.
  Each block is `IfModule`-guarded, so a missing module degrades silently rather
  than 500-ing — which also means a silent no-op if none are enabled. Check.
- Replacing a photo in place from now on needs a new filename or a `?v=` bump,
  or browsers will hold the cached copy for a year. Admin uploads are unaffected
  (Laravel assigns each a fresh random name).
- The 22.7 MB of duplicate files (Section 2.2) is **not** resolved. Post-
  compression it is down to roughly 3 MB of redundancy, but de-duplicating still
  requires rewriting DB rows and seeders, so it belongs with the Phase 2 markup
  work rather than in a zero-reference-churn pass.
- WebP conversion was **deliberately deferred** to Phase 2. It would mean
  rewriting 20 database rows, the seeders, ~30 Blade references, and the admin
  upload paths — real regression risk for perhaps another 25 %. Phase 2 rewrites
  this markup for `<picture>`/`srcset` anyway, which is the right moment.

### Still open (Phase 2)

The home page's 3.31 MB is still almost entirely eager. The hero alone accounts
for 1.69 MB because all six slides render at once, and the below-fold CSS
backgrounds cannot be lazy-loaded. Fixing those (Section 6, Phase 2) should take
the *initial* load under 1 MB without compressing anything further.

---

## Phase 2 — completed

Done on 2026-08-26. No image was re-compressed in this phase; every gain comes
from *what* gets requested and *when*.

### What changed

**`scripts/generate-variants.php`** (new) produces downscaled siblings named
`<name>-<width>w.<ext>` next to each source. It never upscales, and discards any
variant that fails to come out smaller than its source. 61 variants, +5.0 MB on
disk — a deliberate trade: disk is cheap, bandwidth on a phone is not. Remove
them all with `--clean`.

**The hero no longer loads six backgrounds.** Two changes in
`components/home/hero-section.blade.php`:

- `background-image` is now bound only for slides in a `loaded` list, seeded with
  the current slide plus the next one and extended as the visitor navigates. The
  divs still all exist, so the cross-fade is unchanged; an unbound `url()` is
  simply never fetched. `prevSlide` seeds from the slide *before* the new one, so
  the look-ahead follows the direction of travel.
- The thumbnail strip points at `slide.thumb` (the 400w variant, 26–37 KB) rather
  than `slide.image`. Those cards cap at 180 px wide, so pointing them at the
  full-size backgrounds was the reason all six masters loaded even though only
  one was visible.

**LCP preload** added to `layouts/app.blade.php`, gated to the home page. The
first hero background is applied by Alpine after the JS runs, so the preload
scanner never saw it.

**Below-fold CSS backgrounds converted to `<img loading="lazy">`** — background
images have no lazy-loading equivalent, so every one of these was fetched on
first paint: `signature-moments` (4), `experience-section` (2), `final-cta`,
`photo-spots` (4), `bar-section`, `knuckles-highlight`, `pool-relaxation`.
`object-cover` reproduces `bg-cover`/`bg-center` exactly. Decorative ones carry
`alt=""` + `aria-hidden`.

**`page-hero` converted to an `<img>`** with `fetchpriority="high"` — it is the
LCP element on six pages, so it stays eager. It builds its own srcset by probing
for whichever variants exist, and reads real intrinsic dimensions, so it stays
correct as variants are added and degrades to a plain `src` if the storage
symlink is missing.

**`srcset`/`sizes` and `width`/`height`** added across the gallery grid, moment
cards, experience cards, photo spots, and pool highlight. The gallery builds its
srcset defensively, offering only variants that actually exist.

**Remaining eager images given `loading="lazy"`**: experience attraction cards,
nearby-highlight cards, dining atmosphere and signature dishes, wedding tabs, and
both `image-slider` branches.

**Two latent bugs fixed in passing:**

- `pool-highlight` used `bg-cover bg-center` on an `<img>`. Those style a CSS
  background and do nothing to an image element; the fill only looked right
  because that particular source is square. Now `object-cover`.
- `bar-section` and `knuckles-highlight` used `url('storage/...')` with no
  leading slash, which resolves relative to the current document — fine on
  `/dining`, broken on any nested route. Both now use `asset()`.

### Results — initial page load (images actually requested on load)

| Page | Before Phase 1 | After Phase 1 | After Phase 2 |
|---|---|---|---|
| Home | 23.90 MB | 3.31 MB | **732 KB** |
| `/experiences` | 3.38 MB | 2.64 MB | **368 KB** |
| `/weddings` | 4.31 MB | 940 KB | **303 KB** |
| `/luxury-stay` | 2.40 MB | 496 KB | **303 KB** |
| `/dining` | — | ~1.5 MB | **309 KB** |
| `/gallery` | ~14 MB | ~2 MB | **166 KB** |
| `/contact` | — | 203 KB | **203 KB** |

Home now issues 10 image requests on load instead of 16, with 8 images deferred.
The hero fetches 2 full backgrounds instead of 6, plus 6 small thumbnails.

**Total reduction, home page: 23.90 MB → 732 KB (97%).**

### Verification

- All seven public pages return 200; no console errors; no broken images.
- Hero lazy-binding confirmed against live Alpine state: on load `loaded` is
  `[1, 2]` and only `mounts-edge-regency.jpg` and `luxury-suites.jpg` are
  fetched; after one click it becomes `[1, 2, 3]` and `wedding.jpg` is fetched,
  with slides 4–6 still unbound.
- srcset confirmed selecting correctly: a 269 px gallery tile receives the 400w
  variant rather than the 1500 px original; the `/weddings` page hero receives
  `weddings-1400w.jpg` at a 1392 px viewport.
- All 61 generated variants verified on disk at exactly their declared widths.

### Caveat on how this was verified

The preview browser runs with `document.visibilityState === "hidden"`. Chrome
deliberately defers lazy-loaded images and does not advance CSS transitions in a
hidden tab, so two things could **not** be observed end-to-end here:

1. **Lazy images loading on scroll.** They were verified by forcing
   `loading="eager"`, which confirmed every URL and srcset resolves and all 12
   gallery images decode — but the scroll-triggered fetch itself was never seen
   firing. This is standard browser behaviour rather than anything specific to
   this code, but it is untested here.
2. **The hero cross-fade rendering.** Class bindings and Alpine state were
   verified programmatically and are correct; the animation itself was not seen.

Consequently the figures above measure *eagerly requested* bytes. On a real
visible load, any lazy image that happens to fall inside the first viewport will
also load, so treat these as a lower bound — the ordering and the scale of the
reduction hold, but the exact byte counts will be a little higher in practice.
**Worth a quick look in a real browser**, particularly the hero carousel and one
scroll down the home page.

### Still open

- WebP/AVIF (Section 6, Phase 3) — the remaining ~25–30 % on top of this.
- The duplicate files from Section 2.2, now ~3 MB post-compression.
- Upload-time optimisation, so admin uploads do not reintroduce the problem.
- `APP_DEBUG=true` and the missing `config:cache`/`route:cache`/`view:cache`.
- The unused axios import, ~35 KB of the 84 KB JS bundle.

---

## Phase 3 — completed

Done on 2026-08-26. Phases 1 and 2 fixed the symptom; this phase stops it
recurring, and makes the fix reproducible on a server.

### Upload pipeline — `App\Services\ImageOptimizer`

Every admin upload previously landed on disk exactly as it came off the camera.
That is how the library reached 61 MB, and without this it would have drifted
straight back. All four upload paths now route through the service:
`AdminGalleryController` (create and update), `AdminWeddingController`, and the
shared `HandlesImageUploads` trait used for multi-image fields.

The service resizes to a per-folder cap, re-encodes at quality 78 progressive,
and emits the srcset variants the gallery grid probes for. It is deliberately
built on ext-gd rather than `intervention/image`: GD is already a requirement,
the exact code path was validated across all 77 existing files, and it avoids a
`composer install` step on a host that appears to deploy by zip.

**EXIF rotation is handled.** Phones record orientation as a tag rather than
rotating pixels, and GD discards that tag on write — so without correction a
portrait upload would come back sideways. `ext-exif` is not loaded in this
environment, so the tag is parsed straight out of the JPEG APP1 segment.

An optimisation failure never loses an upload: the original is already stored
before optimisation runs, so a failure is logged and the unoptimised file served.

**Deleting an image now deletes its variants too.** Left behind, they outlive
the photo and any srcset still listing them keeps serving the old image.

### `php artisan images:optimize`

For everything that bypasses the upload path — the initial cleanup, files copied
onto a server by hand, anything restored from backup. Same service underneath, so
there is one implementation rather than two that can drift.

`--dry-run` reports without writing; `--force` reprocesses everything.

### Bundle

axios was imported in `resources/js/bootstrap.js` and exposed as `window.axios`,
but nothing in the app ever called it — every form is a plain POST. Removed, and
the package uninstalled.

| | Before | After |
|---|---|---|
| JS | 84.57 KB | **47.81 KB** (17.3 KB gzipped) |
| CSS | 66.46 KB | 66.46 KB |

### Deployment

`docs/DEPLOYMENT.md` covers production env values, the build/cache commands, how
to actually get images onto the server (they are not in git), and how to verify
the `.htaccess` cache headers really applied.

### Two bugs found by testing, not by reading

Both were in code written during this phase, and both were caught only by
running the command twice and diffing the bytes:

1. **The "never write a bigger file" guard only applied when the image was not
   being resized.** Files that Phase 1 had left at their original dimensions were
   resized, produced a *larger* re-encode, and had it written anyway — 10 files
   grew by 107 KB on the first run.
2. **The command was not idempotent.** Re-encoding an already-processed JPEG
   shrinks it slightly while compounding artefacts, so every run was a small,
   invisible quality leak. A bytes-per-pixel heuristic was tried first and was
   not good enough — detailed photos legitimately need more bytes per pixel, so
   23 files still re-encoded on every pass.

The fix for (2) is a manifest at `storage/app/image-optimizer.json` recording the
checksum of each file as the command left it. A file whose checksum still matches
is skipped outright; a replaced file fails to match and gets reprocessed. Run 2
is now byte-for-byte identical to run 1.

The variant width lists were also aligned to the widths the templates actually
request — the first version generated 82 variants, 21 of which nothing would ever
have requested.

### Verification

- Upload path tested end to end with a synthetic 3000×2000 / 1249 KB upload:
  stored at 1500×1000 / 97 KB, both variants written, `forget()` removed them.
- EXIF orientation tested by splicing real APP1 segments into a JPEG. Tags 1, 3,
  6 and 8 all parse correctly and 6/8 swap the dimensions as expected. Rotation
  *direction* was verified separately by pixel sampling — a red-left/blue-right
  landscape image rotates to red-top under tag 6 and blue-top under tag 8, so the
  correction is not accidentally 180° out.
- `images:optimize` run twice from a clean restore: 26 re-encoded and 61 variants
  on the first pass, then 0 and 0, byte-identical.
- All 138 images decode; nothing grew; no file lost.
- All seven pages return 200, Alpine boots, home page still 731 KB / 10 requests,
  no console errors, no broken images.

### Deliberately not done

- **Self-hosting Google Fonts.** It would remove a third-party round trip from
  the critical path, but `preconnect` and `display=swap` are already in place, so
  the remaining gain is small against the risk of picking wrong subsets or
  dropping a weight. Left as a judgement call rather than done silently.
- **`APP_DEBUG=false` in the local `.env`.** That file is the development
  environment and gitignored; changing it would only break local debugging. The
  production values are in `DEPLOYMENT.md`.

### Still open

- **WebP/AVIF** — the largest remaining win, roughly 25–30 % on top of current
  sizes. Now considerably cheaper than it was: most templates already emit a
  srcset, so the work is generating `.webp` alongside each variant and wrapping
  those srcsets in `<picture>`. The DB rows keep their `.jpg` paths as the
  fallback `<source>`, so nothing has to be migrated.
- **~3 MB of duplicate files** (Section 2.2). Still needs DB rows, seeders, and
  Blade references pointed at one canonical copy.
- **`storage/app/image-originals/`** (62 MB) is the Phase 1 backup. Gitignored
  and local-only; delete it once the results have been confirmed in production.

---

## Phase 4 — WebP

Done on 2026-08-26.

### The projection was wrong, and that changed the design

Phases 1–3 assumed WebP would save 25–30%. Measured against these files first,
the real figure is **18.4% overall — and it ranges from 3.8% to 41.3%**. The
reason is that Phase 1 already compressed everything properly: WebP's advantage
is largest over *badly* encoded JPEGs, and there were none left.

At 3.8%, a WebP sibling is not worth a second file on disk, a second cache entry,
and an extra `<source>` for the browser to evaluate. So conversion is gated on a
minimum saving (`WEBP_MIN_SAVING`, 10%): **101 of a possible 139 files got a
WebP; the other 38 are served as JPEG to everyone.** Measuring before building
turned "convert everything" into "convert what actually pays".

### `<x-responsive-image>`

Hand-writing `<picture>` in a dozen templates would have been repetitive and
easy to get subtly wrong, so the markup lives in one component
(`components/responsive-image.blade.php`), now used in **13 templates**. Given a
`src` and a list of widths it probes the filesystem and emits the WebP `<source>`,
the raster `srcset` fallback, and intrinsic `width`/`height` — all of which
degrade to a plain `<img>` when the files are not there.

Two details worth keeping:

- **`<picture class="contents">`.** `display: contents` means the wrapper creates
  no box, so every `absolute inset-0` and `h-full` image behaves exactly as it
  did before being wrapped. Without it, percentage heights would resolve against
  an inline `<picture>` and collapse.
- **The WebP source is only used when it covers the largest candidate width.** A
  `<source>` that matches wins the negotiation outright, so if the biggest size
  were missing, a wide viewport would be handed an undersized WebP and render it
  blurry. Missing *intermediate* widths are harmless — worst case is a slightly
  larger download.

### The hero needed a different mechanism

The hero backgrounds are CSS, not `<img>`, so `<picture>` does not apply. They
use `image-set()` with a plain `url()` declared first:

```
background-image: url('…luxury-suites.jpg');
background-image: image-set(url('…luxury-suites.webp') type('image/webp'), …);
```

A browser that understands `image-set()` takes the second declaration; one that
does not discards it as invalid and keeps the first. No feature detection, no JS
branch. Confirmed serving `luxury-suites.webp` in the preview browser.

The thumbnail strip uses `<template x-if="slide.thumbWebp">` so a slide with no
WebP emits no `<source>` at all — an empty `srcset` would match nothing and blank
the card.

### Results — initial page load

| Page | Baseline | After Phase 3 | After Phase 4 |
|---|---|---|---|
| Home | 23.90 MB | 732 KB | **575 KB** |
| `/experiences` | 3.38 MB | 368 KB | **342 KB** |
| `/dining` | — | 309 KB | **254 KB** |
| `/weddings` | 4.31 MB | 303 KB | **252 KB** |
| `/luxury-stay` | 2.40 MB | 303 KB | **201 KB** |

**Home page total: 23.90 MB → 575 KB, a 97.6% reduction.**

Disk cost: 27.4 MB total (12.5 MB originals + 5.0 MB variants + 9.9 MB WebP).
Still less than half the 61.6 MB the site started with, while serving a fraction
of it per visit.

### A latent production bug found on the way

`nearby-highlights.blade.php` referenced `seetha-kotuwa.jpg`, but the file on
disk is `seetha-kotuwa.JPG`. Windows is case-insensitive so it renders fine
locally — **on a Linux server that is a 404 and a visibly broken card.** It
predates this work; the WebP pass surfaced it because the generated sibling
exposed the mismatch. The file is renamed to lowercase, matching every other file
in the library.

All 61 referenced storage paths were then audited case-sensitively against the
filesystem: this was the only mismatch, and nothing is missing.

### Verification

- All seven pages return 200, no console errors, no broken images.
- All 12 gallery tiles serve `.webp`; the `/weddings` hero serves
  `weddings-1400w.webp`; the home hero serves `luxury-suites.webp` via
  `image-set()`.
- Slides below the WebP threshold correctly fall back: the first hero background
  and `nature-trails-400w` are still served as JPEG.
- Hero lazy-binding still intact after the rewrite — `loaded` is `[1,2]` on load
  and `[1,2,3]` after one advance.
- `::class` escaping verified: Alpine bindings pass through the component as
  `:class`, with no literal `::class` leaking into the HTML.
- Upload path re-tested: a 2600×1700 / 567 KB upload stores at 1500×981 / 79 KB
  with WebP at 47 KB, both variants plus their WebP siblings written, and
  `forget()` removes all of them.
- `images:optimize` still idempotent — a second run reports 0 changes.

---

## Phase 5 — de-duplication

Done on 2026-08-26.

### Most of the 22.7 MB had already gone

Section 2.2 recorded ten duplicate groups totalling 22.7 MB. Re-measuring first
showed that Phase 1 had already resolved most of it: those folders have different
size caps, so six of the ten groups are now **the same photo at different
dimensions** — 1500 px for the gallery lightbox, 800 px for a moment card, and so
on. That is correct and intentional; collapsing them would be a regression.

What actually remained was **four byte-identical groups, 1.16 MB**.

### What was done

**Two were dead files** — present in neither templates, seeders, nor the
database:

- `home/mounts-edge-regency.jpg` (superseded by the copy in `home/hero/`)
- `weddings/3tKybPf…jpg` (an upload replaced by `outdoor-hall.jpg`)

**Two were genuinely referenced twice**, and were consolidated onto
`hero-images/` as the canonical location for a photo used by more than one
section:

| Photo | Was | Now |
|---|---|---|
| Weddings | `hero-images/weddings.jpg` + `home/experiences/weddings.jpg` | `hero-images/weddings.jpg` |
| Stay | `hero-images/stay.jpg` + `home/hero/luxury-suites.jpg` | `hero-images/stay.jpg` |

The home hero gained an optional `base` key so a slide can source its image from
outside `home/hero/`, and `hero-images/` gained a 400w variant to feed the hero
thumbnail strip (which also benefits mobile page heroes).

**Trade-off worth knowing:** these two photos are now shared, so replacing the
`/weddings` hero image will also change the home page's "Celebrate" card. If
those should be able to diverge later, re-split them rather than editing in
place.

### A WebP bug this surfaced

Consolidating exposed a flaw in the Phase 4 rule that a WebP `<source>` only
needed to cover the *largest* candidate width. The home "Celebrate" card wants an
800w, but `hero-images/weddings` only had WebP at 1400w and 1600w — and because a
matching `<source>` wins the negotiation outright, the browser was forced up to
**the 1400w WebP (215 KB) instead of the 800w JPEG (109 KB)**. Partial coverage
was worse than no WebP at all.

Fixed in two places:

- `ImageOptimizer::makeWebp()` now judges the 10% threshold **once, on the
  full-size image, and applies it to the whole group** — so an image either gets
  WebP at every width or none at all.
- `<x-responsive-image>` now requires **full** coverage before emitting the
  `<source>`, instead of just the largest width.

Verified by building the srcset in a controlled container with cache-busted URLs:
a 451 px card now resolves to `800w`, and a 1280 px hero to `1400w`, for both
images.

### Results

| | Before | After |
|---|---|---|
| Duplicate groups | 4 | **0** |
| Files | 240 | 235 |
| Disk | 27.40 MB | **25.12 MB** |

Disk fell by 2.28 MB even though the WebP coverage fix *added* files.

Per-page initial bytes are essentially unchanged — de-duplication changes which
URL a page requests, not how much it loads. The one real gain is cross-page cache
reuse: the home hero and `/luxury-stay` now share `hero-images/stay.*`, so a
visitor moving between them re-uses the file instead of downloading a second
copy.

### Verification

- All 54 referenced storage paths resolve to a real file; 0 missing.
- 0 byte-identical duplicate groups remain.
- All seven pages return 200, no console errors, no broken images.
- `images:optimize` still idempotent after the `makeWebp` restructure.

### Unreferenced uploads — removed

A scan for originals referenced nowhere (templates, seeders, or database)
initially flagged ten files, but **five were false positives**:
`home/hero/nature-trails.jpg`, `home/hero/wedding.jpg` and
`weddings/highlights/{1,3,4}.jpg` build their paths at runtime from `'file'` and
`'stem'` keys, so no literal string appears in the source. **Any future orphan
sweep must account for dynamically-built paths, or it will delete live images.**

The other five were genuinely unused and have been deleted, along with their
variants and WebP siblings — 12 files, 0.97 MB:

| Original | Why it was unused |
|---|---|
| `gallery/food3.jpg` | not among the 12 rows in `gallery_items` |
| `gallery/7ccb010d…jpg` | not in `gallery_items` |
| `rooms/Ra5CmU…jpg` | not in `rooms.image` or `rooms.images` |
| `rooms/QN3hIo…jpg` | not in `rooms.image` or `rooms.images` |
| `experiences/attractions/boat-ride2.jpg` | the attractions list uses `boat-ride.jpg` |

Each was checked three ways before deletion — grep across `resources/`,
`database/`, `app/`, `routes/` and `config/`; a substring match against every
image column in the database; and confirmation that a copy still exists in the
Phase 1 backup at `storage/app/image-originals/`, so all five remain recoverable.

Verified afterwards: all seven public pages 200, admin routes still redirect to
login, `/gallery` renders all 12 tiles, and no page has a broken image or a failed
request.

### Final disk state

| | Files | Size |
|---|---|---|
| Originals | 69 | 10.65 MB |
| srcset variants | 57 | 4.45 MB |
| WebP siblings | 97 | 9.04 MB |
| **Total** | **223** | **24.15 MB** |

Down from 61.6 MB at the start, while serving a small fraction of it per visit.

### Note on the standalone scripts

`scripts/optimize-images.php` and `scripts/generate-variants.php` were the Phase
1 and 2 one-off tools. `php artisan images:optimize` now supersedes both and
shares its implementation with the upload path, so prefer it. The standalone
optimiser is kept only for its `--restore` flag, which restores from the Phase 1
backup; delete both scripts along with that backup once production is confirmed.
