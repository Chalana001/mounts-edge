# Shared UI Component System Implementation

Goal: build the reusable UI primitives from the audit roadmap and migrate the existing views, so typography/spacing/CTA/color rules are locked in one place instead of ~30 templates.

All components live in `resources/views/components/`. Existing Breeze primitives (`primary-button`, `text-input`, etc.) stay untouched — they serve auth/admin forms with a different visual language. The new primitives are for the public marketing site.

## New components

### 1. `<x-section-heading>` — eyebrow + serif h2 + optional intro
Props: `eyebrow`, `title`, `intro` (optional), `surface` (light|dark, default light), `align` (center|left, default center).
- Light: eyebrow `text-brand-green/70`, h2 `text-brand-green text-3xl md:text-4xl` (or `md:text-5xl` variant via `size` prop where current pages genuinely use it), intro `text-brand-green/70`.
- Dark: `text-brand-cream/70` / `text-brand-light`.
- One standard margin rhythm (`mb-10 md:mb-14`) so headings stop drifting.

### 2. `<x-cta-button>` — the single CTA system
Props: `href` (link) or render as `<button>` when no href, `variant` (primary|secondary|light|outline-dark), `external`, extra attributes passthrough (keeps `data-conversion` tracking attrs).
- Canonical sizing: `inline-flex min-h-12 items-center justify-center rounded-none px-8 py-4 text-[11px] tracking-[0.2em] uppercase font-bold`.
- primary: `bg-brand-green text-brand-light hover:bg-brand-hover`
- secondary (light ground): `border border-brand-green/30 text-brand-green hover:border-brand-ember hover:text-brand-ember` (encodes the ember rule)
- light (dark ground): `bg-brand-light text-brand-green hover:bg-brand-cream`
- outline-dark (dark ground): `border border-brand-cream/60 text-brand-light hover:border-brand-orange hover:text-brand-orange`
- WhatsApp CTA uses primary classes + `bg-whatsapp hover:bg-whatsapp-dark` via a `whatsapp` variant.
Preserves: `target=_blank rel=noopener` when external; conversion attributes passed through.

### 3. `<x-container-section>` — one container/section rhythm
Props: `maxWidth` (sm|md|lg|xl mapping to max-w-3xl/4xl/5xl/6xl, default none/container), `padding` (standard|compact → py-12 md:py-20 | py-10 md:py-16), slot, attributes passthrough (`bg-white` etc. land on `<section>`).
- Renders `container mx-auto px-6` (+ optional max-w) so nested px drift ends.

### 4. `<x-form-field>` — label + input + error in one
Props: `label`, `name`, `type` (default text), `value` (old() handled by caller — component renders what's passed), `required`, `error` (the `$errors->get(...)` array), `options` (for select), `rows` (textarea), `inputmode`, `autocomplete`, `placeholder`.
- Label: current public form's uppercase 11px convention.
- Field: the form's existing `$fieldClass` styling centralized (p-4, brand borders, focus:border-brand-orange).
- Error: `<x-input-error>` inside, `space-y-1.5` wrapper.
- This removes ~18 hand-built field blocks in the contact form; input names (`details[check_in]` etc.) stay EXACTLY as-is so controller validation doesn't change.

### 5. `<x-surface-link>` — light/dark accent link
Props: `href`, `surface` (light|dark). Light: `text-brand-green hover:text-brand-ember`; dark: `text-brand-cream/70 hover:text-brand-orange`. Used for the inline text links inside CTA copy (currently hand-typed per page).

### 6. `<x-error-page>` — deduplicate 403/404/500
Props: `code`, `title`, `message`, `actions` (array of label/href/variant). The three error views become ~10 lines each, keeping their `page.title`/`page.robots` sections. The 404's five actions pass through with the first as primary.

### 7. Gallery caption min-height
In `gallery/grid.blade.php`: caption container gains `min-h-[3.25rem] md:min-h-20` so short/long captions sit consistently; keep the existing mobile/hover reveal mechanics.

### 8. Wedding testimonial typography
`testimonial.blade.php`: quote `text-2xl md:text-4xl leading-[1.6]` → `text-xl md:text-3xl leading-[1.35]` per audit; convert static content to props with current values as defaults (no data migration, no DB).

### 9. Floating actions props
`floating-actions.blade.php`: add `@props(['showBackToTop' => true])`, normalize the WhatsApp number (strip spaces/+/dashes) before building the URL, and don't render the WhatsApp button if the number is empty. Global layout usage unchanged.

### 10. Migration scope (where the components get used)
- **section-heading**: migrate the main section headers on rooms, dining, weddings, experiences, gallery, contact page sections (~12 call sites). NOT every admin heading — admin is a separate visual language.
- **cta-button**: migrate public CTAs — cta-strip, rooms booking-cta, dining reserve/wedding CTA, weddings whatsapp-cta, experiences cta, home final-cta, contact quick-actions, 404 buttons, enquiry submit (~15 sites).
- **container-section**: migrate the CTA band sections (cta-strip, booking-cta, wedding-cta, experiences cta) where the `py-12 bg-brand-orange/5 border-y` pattern repeats; other content sections keep their bespoke layouts but adopt the component where it's a drop-in.
- **form-field**: migrate the entire contact form's ~18 fields.
- **surface-link**: migrate the inline links inside CTA paragraphs (rooms/dining/weddings/experiences copy).

## What this is NOT
- No new design direction: every component encodes classes already on the site today (post-audit-fix state). This is deduplication, not a redesign.
- No gallery Alpine/lightbox refactor (the explore agent confirmed splitting it risks breaking filter/lightbox navigation — tile extraction deferred).
- No contact-form controller/validation changes.
- No testimonial DB model (props with defaults now; CMS later if ever needed).
- Full "typography standardization across every section" is achieved for the migrated sections; intentionally-idiosyncratic sections (hero, gallery masonry, testimonial) keep their character.

## Order of work
1. Build the 6 new components (1–6 above) — no template changes yet.
2. Migrate error pages to `<x-error-page>` (lowest risk, proves the pattern).
3. Migrate CTAs to `<x-cta-button>` + inline links to `<x-surface-link>`.
4. Migrate section headings to `<x-section-heading>`.
5. Migrate the CTA bands to `<x-container-section>`.
6. Migrate the contact form to `<x-form-field>` (biggest single change; field names untouched).
7. Gallery caption min-height + testimonial typography + floating-actions props.
8. Update `docs/UIUX-AUDIT.md` roadmap section marking items 1–8 delivered.
9. Verify: full test suite, all pages + 404 return correct statuses, visual spot-check of a page per area (hero, CTA, form render, gallery captions), `git commit`.

## Risk notes
- Blade `@props` with default `null` for optional slots keeps components callable without breaking missed migrations — migration is incremental, not big-bang.
- The contact form migration is the only risky step; it gets its own verification (submit-path tests exist in the suite — enquiry tests).
- If any component's canonical class conflicts with a specific page's intentional variation, that page keeps its inline classes and gets a code comment; the component wins everywhere else.