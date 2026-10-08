# Mounts Edge Regency — UI/UX Audit

**Date:** 2026-10-08
**Method:** Code-level inspection of every public Blade template against the design tokens in `tailwind.config.js` (brand-green `#1a2e2a`, brand-orange `#fe7f02` fills + dark-ground text, brand-ember `#A25201` light-ground text, brand-cream, brand-light; Playfair Display serif, Lato sans). Every finding cites `file:line`. Severity: **P1** usability/contrast failure, **P2** noticeable inconsistency or mobile risk, **P3** polish.

**Status:** Findings below. P1s and the highest-value P2s/P3s were fixed the same day (see §Fixes applied). The rest stay open as a roadmap.

---

## Home (`welcome.blade.php` + `components/home/*`)

1. **P1** `hero-section.blade.php:108` — mobile thumbnail rail uses `w-[calc(100%+1.5rem)]` (intentional edge-bleed) but risks horizontal overflow/clipped cards at 320px.
   Fix: `w-full` on the rail, move the bleed to an inner element.
2. **P2** `hero-section.blade.php:93` vs `final-cta.blade.php:36` — hero CTAs `rounded-sm` + clamp paddings; final CTA `rounded-none px-12 py-5`. Two CTA languages on one page.
   Fix: normalize both to `rounded-none px-10 py-4 text-[11px] tracking-[0.2em] uppercase font-bold min-h-12`.
3. **P2** `why-choose-us.blade.php:54` — 2-col mobile grid with `text-xs` descriptions; narrow measure, small body copy.
   Fix: `grid-cols-1 sm:grid-cols-2 lg:grid-cols-4`, `text-xs sm:text-sm`.
4. **P3** `trust-bar.blade.php:1` vs siblings — section rhythm drifts (`py-10 md:py-16` vs `py-12 md:py-20`) without a named variant; fine visually but undocumented.
   Fix: `section-compact` / `section-standard` conventions (roadmap).

## Rooms (`components/rooms/*`)

1. **P1** `contact/form.blade.php:74,109` — enquiry form conditional fields use `grid-cols-2` at base; date pickers cramp on 320-390px phones.
   Fix: `grid-cols-1 sm:grid-cols-2 md:grid-cols-4`.
2. **P2** `room-tabs.blade.php:16` — tablist adds `px-4 md:px-6` inside the container's `px-6`; mobile tabs are `w-full`.
   Fix: remove nested padding; `min-w-0 flex-1 px-3` buttons.
3. **P2** `room-tabs.blade.php:55` — `min-h-[500px] md:min-h-[600px]` reserves large blank space for short panels.
   Fix: `min-h-0` (transitions tolerate zero floor).
4. **P3** `amenities.blade.php:1,9` — fixed `py-16`, non-responsive `text-4xl` heading, off-scale vs the page's `py-12 md:py-20`.
   Fix: `py-12 md:py-20`, `text-3xl md:text-4xl`.

## Weddings (`components/weddings/*`)

1. **P2** `tabs-section.blade.php:17` — same nested `px-6` + `w-full sm:w-[220px]` tab problem as Rooms.
2. **P2** `whatsapp-cta.blade.php:9` — CTA padding/radius drift; secondary hover uses `brand-orange` border on a light-orange ground.
   Fix: `hover:border-brand-ember hover:text-brand-ember`.
3. **P3** `tabs-section.blade.php:53` — `space-y-16 md:space-y-24` inter-item gaps dwarf the section padding; editorial scale.
   Fix: `space-y-12 md:space-y-16`.
4. **P3** `testimonial.blade.php:17` — `text-2xl md:text-4xl leading-[1.6]` reads oversized at both ends.
   Fix: `text-xl md:text-3xl leading-[1.35]` (deferred — roadmap).

## Dining (`components/dining/*`)

1. **P1** `dining-spaces.blade.php:31` — `whitespace-nowrap` hours inside a 2-col mobile grid overflows at 320px ("Open daily · 6:30 AM - 10:00 PM").
   Fix: drop `whitespace-nowrap`; `grid-cols-1 sm:grid-cols-2`.
2. **P2** `signature-dishes.blade.php:37` — 2-col mobile + `text-[11px]` descriptions.
   Fix: `grid-cols-1 sm:grid-cols-2 lg:grid-cols-4`, `text-xs sm:text-sm`.
3. **P2** `reserve-cta.blade.php:1` → `wedding-cta.blade.php:2` — dark CTA block followed by pale CTA strip with different button treatments.
   Fix: normalize button classes (done); variants system is roadmap.
4. **P2** `dining-spaces.blade.php:11,20` — `p-8 md:p-12` cards with a cramped base grid; fix grid first (done with P1 #1).

## Experiences (`components/experiences/*`)

1. **P2** `attractions.blade.php:67` — `xl:grid-cols-4` makes narrow cards on large screens; inconsistent card heights.
   Fix: `md:grid-cols-2 lg:grid-cols-3`.
2. **P2** `nearby-highlights.blade.php:110` — `p-8` at every breakpoint across 15 cards; heavy on mobile.
   Fix: `p-5 sm:p-6 md:p-8`.
3. **P3** heading scale drift — `text-4xl md:text-5xl` here vs `text-3xl md:text-4xl` on Home for the same role (roadmap: shared heading component).

## Gallery (`components/gallery/*`)

1. **P2** `grid.blade.php:26` — filter chips lack `whitespace-nowrap`; long labels wrap to 2 lines and stagger the row.
   Fix: `whitespace-nowrap px-4 md:px-6`.
2. **P2** `grid.blade.php:104` — caption `text-brand-orange` sits over a dark scrim today, but orange-on-light is only 2.7:1; fragile to scrim changes.
   Fix: `text-brand-cream md:text-brand-orange` (mobile-first contrast).
3. **P3** `grid.blade.php:15,27,46` — heading/filter/grid each carry their own `px-6`/container; alignment is correct but drift-prone (roadmap: one container).
4. **P3** `grid.blade.php:114` — captions have no min-height; long/short descriptions sit inconsistently (roadmap).

## Contact (`components/contact/*`)

1. **P1** `form.blade.php:74,109` — as Rooms #1 (same component).
2. **P2** `info-cards.blade.php:45` — 2-col mobile with 9×9 icons and 11px text; address/email cards get tight.
   Fix: `grid-cols-1 sm:grid-cols-2 md:grid-cols-4`, `w-10 h-10 md:w-12 md:h-12`, `text-xs md:text-sm`.
3. **P2** `quick-actions.blade.php:3` — three `py-5` full-width rows in a `py-12 md:py-20` section.
   Fix: `py-10 md:py-16`, buttons `px-8 py-4`.
4. **P3** `form.blade.php:10` — `p-4` inputs vs 11px labels; hierarchy mismatch (roadmap: form-field component).

## Error pages (`errors/404|403|500.blade.php`)

1. **P2** `404.blade.php:16` — five equal-weight buttons; wrapping produces tall multi-rows of equal choices.
   Fix: primary Rooms button (`w-full sm:w-auto`) + smaller secondary links.
2. **P3** all three pages duplicate the same layout — `error-page` component (roadmap).
3. **P3** floating actions dominate sparse error pages (roadmap: compact variant).

## Shared chrome

1. **P1** `navbar.blade.php:118` — unscrolled active link is `text-brand-orange` over arbitrary hero photography; no guaranteed background. Orange is only speced for dark solid grounds.
   Fix: `text-brand-light` when not scrolled, keep the orange underline indicator; ember on the scrolled cream bar.
2. **P1** `navbar.blade.php:69,116` — at `lg`: 6 links + brand + CTA in one row with `px-6`; already visibly tight (existing gap-6 workaround).
   Fix: `gap-4 xl:gap-8` + smaller CTA at `lg`.
3. **P2** `floating-actions.blade.php:5` — ~112px fixed stack at `bottom-6 right-6` can cover forms/captions on small screens.
   Fix: `bottom-4 right-4 sm:bottom-6 sm:right-6`.
4. **P2** `footer.blade.php:16` — fixed `gap-8` nav on mobile; uneven wrap.
   Fix: `gap-x-5 gap-y-3 sm:gap-8`.
5. **P3** `footer.blade.php:36` — contact info at `text-xs` though it is conversion content.
   Fix: `text-sm`.
6. **P3** `navbar.blade.php:130` — Book CTA lacks shared sizing (roadmap: cta-button).

---

## Top 5 systemic issues

1. **Container discipline** — nested `px-4/6` inside `container px-6` on room tabs, wedding tabs, gallery filters, dining grid.
2. **Mobile grids too aggressive** — base `grid-cols-2` with 11px text across home features, dish cards, contact cards, form fields.
3. **CTA styling duplicated, not tokenized** — padding px-6 py-3 → px-12 py-5; radius `rounded-sm`/`rounded-none`/none; inconsistent hover states.
4. **Typography/tracking drift** — same-role headings alternate 3xl/4xl/5xl; labels track 0.15em→0.4em.
5. **Brand-orange contrast is contextual** — orange used as text where the background can vary; ember should own light grounds, orange solid dark grounds/fills.

## Component extraction roadmap (future)

| Component | Scope | Benefit |
|---|---|---|
| `section-heading` | small | one heading scale + eyebrow pattern |
| `cta-button` | medium | primary/secondary/WhatsApp/light/dark variants |
| `container-section` | small | kills nested-padding drift |
| `responsive-grid` | medium | safe mobile presets |
| `eyebrow-label` | small | tracking + contrast standard |
| `surface-link` | small | encodes the orange/ember rule |
| `error-page` | small | deduplicates 404/403/500 |
| `form-field` | medium | label/input/error + mobile grids |
| `floating-actions` variants | small | compact/hidden-WhatsApp modes |
| `page-hero` refinements | small | overlay + title alignment guarantees |

## Fixes applied (2026-10-08)

P1s (4/4): form grids, dining hours + grid, navbar unscrolled active contrast, navbar lg tightness.
P2s: hero rail, home/dish/info-card mobile grids, room+wedding tablists, room panel min-h, nearby card padding, attractions grid, gallery chips + caption, footer gaps, floating actions offset, 404 primary/secondary actions, CTA class normalization.
P3s: amenities rhythm, wedding split spacing, footer contact size.
Deferred to roadmap: shared components, testimonial typography, gallery caption min-heights, floating-actions per-page variants, form-field abstraction.

Verify: `php artisan test` full suite green; all pages 200.
