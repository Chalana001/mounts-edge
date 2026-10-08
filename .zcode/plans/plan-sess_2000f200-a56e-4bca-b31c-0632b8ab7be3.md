Four-part plan, ordered so changes stay cleanly separated (the UI commit goes first because the gallery-grid alt-text work would otherwise mix with your unstaged gallery-grid edits).

## Part 1 — Commit your unstaged UI work

Commit the 35 modified files + 6 untracked files as one coherent rebrand/a11y pass, split into two commits:

**Commit A: "Add brand system, logo suite, and favicons"**
- `resources/views/components/logo.blade.php`, `brand-name.blade.php` (new)
- `public/favicon.svg`, `public/apple-touch-icon.png`, `public/favicon.ico` (fixes the previously-empty 0-byte ico), `public/images/` (10 logo/OG files)
- `resources/views/components/application-logo.blade.php`, `tailwind.config.js` (brand tokens), `resources/css/app.css` (reduced-motion block)

**Commit B: "Apply brand tokens and accessibility polish across views"**
- Navbar (mark+wordmark lockup, mobile-menu focus trap/Escape), nav-link/responsive-nav-link/dropdown-link focus-visible rings
- Home hero carousel accessibility (pause on hover/focus/hidden, reduced-motion), contact form autocomplete/inputmode
- Hardcoded hex → brand tokens sweep across all admin views, dashboard, profile pages
- page-hero consolidation for contact/experiences/gallery heroes; gallery grid staggered reveal
- `.claude/launch.json` (artisan-serve config), `welcome.blade.php` (stray csrf meta removed), `server.php` (standard Laravel router)

**Decision made:** `optimize-images.mjs` — untracked, unreferenced, duplicates the committed `ImageOptimizer` service, outputs to a directory nothing reads. **Leave it untracked and untouched** (safest; not deleted, just not committed). Flag it to you in the final summary.

**Pre-commit verification:** run the full test suite after the commits (84 tests were green before; these files don't touch app logic, but the views render in many tests).

## Part 2 — Custom branded 404 page

Create `resources/views/errors/404.blade.php` extending `layouts.app`:

- Branded "Page not found" panel matching the site's style (brand-green/serif typography, consistent with hero sections), with links to Rooms, Weddings, Dining, Gallery, and Contact (with the enquiry CTA)
- Title override to "Page Not Found | Mounts Edge Regency" — the layout hardcodes `$seo['title']`, so add a title section mechanism: extend `layouts/app.blade.php` with `@hasSection('page.title')` fallback logic (minimal, 2-line change)
- **noindex for the 404**: the layout emits `index, follow` unconditionally at line 19. Add `@hasSection('page.robots')` override so error pages can set `noindex, follow` (follow keeps internal-link crawling alive; noindex keeps the bad URL out of the index). Default stays `index, follow` for all normal pages — no behavior change elsewhere.
- Don't use `<x-seo-intro>`/`$seo` in the error view (composer list doesn't cover it); the layout's inline SeoMeta fallback handles head tags safely, including a null route name (verified: `fallbackPage()` covers it)
- Verification: request a bogus path with curl → expect 404 status + branded content + noindex tag; confirm navbar/footer/floating WhatsApp render (wildcard `$siteSettings` composer covers error views)

Also create `errors/403.blade.php` and `errors/500.blade.php` (minimal branded variants, same mechanism) — cheap while the pattern is set up, and admins hitting bad model IDs currently get the default black page. 419/419-type pages stay default (they're rare and CSRF-specific).

## Part 3 — Gallery alt-text pass

Fix the three inconsistent alt/fallback paths in `components/gallery/grid.blade.php` by giving GalleryItem a single source of truth:

1. **Model accessor** `GalleryItem::altText()` (or `getAltTextAttribute`): returns `description` if set, else `"{Category} at Mounts Edge Regency"` (e.g. "Pool at Mounts Edge Regency"). Used by grid `<img>` alt (currently line 100 passes raw `null`), lightbox alt, lightbox figcaption, and open-button aria-label — one consistent string everywhere.
2. **Seeder descriptions upgraded to unique, factual alt sentences** (12 items): e.g. room1 "Suite bedroom" → "Suite bedroom with warm lighting at Mounts Edge Regency", wedding3 "Bridal room" → "Bridal dressing room prepared for a wedding at Mounts Edge Regency", food1 → "Sri Lankan rice and curry served at Mounts Edge Regency", pool2 → "Infinity pool lit at night at Mounts Edge Regency", etc. Each describes the actual photo, mentions the hotel for entity context, stays under ~125 chars (screen-reader best practice). No new facts invented — describing images already on the site.
3. **Sync the live DB** the same way as the rooms pass: update the 12 `description` columns via tinker (firstOrCreate never updates existing rows). No schema migration needed — reusing the existing nullable `description` varchar(255) column and the admin "Short Description" edit field, so admins can keep maintaining alt text with no new UI.
4. **Update the admin edit field label/help** in `admin/gallery/index.blade.php` from "Short Description" to "Alt text / caption" with a one-line help hint ("Describe the photo for search engines and screen readers") — tiny, keeps future admin input aligned with the new purpose.

Verification: `/gallery` renders 12 unique non-empty alt attributes (curl + regex count), lightbox alt matches, and the image sitemap titles still work (they already use description via `appendImages` — improved automatically).

## Part 4 — Meta description trim

`app/Support/SeoMeta.php` — four descriptions exceed ~155 chars (SERP truncation risk):

| Route | Current | Action |
|---|---|---|
| home | 164 | Trim to ≤155, keep "Gurulupotha near Hasalaka and Mahiyangana" |
| weddings | 187 (worst) | Cut ~35 chars: drop "an indoor hall"/"an outdoor lawn" phrasing, keep capacities + "outside vendors welcome" |
| dining | 163 | Trim: keep hours, bar, walk-ins — drop the "Sri Lankan and international dining" duplication (title already says "Dining") |
| DEFAULT_DESCRIPTION (fallback, also the Hotel schema description) | 163 | Trim to ≤155 — one edit covers both meta and schema |

All titles are already ≤58 chars — no changes there. OG image already verified 1200×630 — no change.

Verification: re-run `php artisan test --filter=SeoFoundationTest` (all 5 must pass), plus a quick character-count check of each description in the rendered pages.

## Final step

Commit Part 2 (404 pages), Part 3 (gallery alt), and Part 4 (meta trim) as three small commits after the two UI commits from Part 1 — five commits total for the whole batch. Run the full test suite once at the end (84+ tests green). Update `docs/SEO-PLAN.md` Phase 5 line to note the alt-text pass is started (12 gallery items done; other images later).