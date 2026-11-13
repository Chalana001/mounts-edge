# Mounts Edge Regency — Pre-Launch SEO Plan

**Status:** Phase 0 VERIFIED 2026-10-08 (signed by hotel manager) — canonical contact, rooms, weddings, dining, attractions, policies, hotel-operated services, photo rights, and supplied listing URLs are owner-confirmed; Phase 3 still owns claiming/verifying the Google profile and exact social/OTA ownership. Phase 1 defects fixed 2026-10-07: `site_settings` synced by migration, conversion events unified, dynamic `robots.txt` serving, auth pages noindexed, and the `$seo` page-view error resolved.
**Last updated:** 8 October 2026
**Audience:** Hotel management, marketing, and the Laravel development team

## Purpose

Launch Mounts Edge Regency as a trustworthy first-party hotel entity for Gurulupotha, Hasalaka, and Mahiyangana. The website must support direct enquiries, complement Google Business Profile and OTA listings, and build lasting visibility for stays, weddings, dining, day-out packages, and genuine local experiences.

This is a long-term visibility plan, not a promise of a particular Google position. Search and AI results are personalized, location-dependent, and change over time. The goal is to create the factual, technical, local, and editorial signals required to compete sustainably.

## Evidence and planning rules

The plan is informed by the supplied Gemini and ChatGPT research reports plus the Google hotel profile screenshot. The screenshot confirms the following working facts on 30 September 2026:

- Business name: **Mounts Edge Regency**
- Google rating: **4.0** from **348 Google reviews**
- Google hotel classification: **3-star hotel**
- Phone displayed by Google: **055 225 6500**
- Map context: **Kandy Rd, Gurulupotha**

The website's rooms, wedding halls, packages, gallery, and amenities are database-driven and editable by administrators. Seeded values in the development database are placeholders; they must never be treated as hotel facts or published merely because they exist in the application.

Before publishing any business claim, use one of these sources:

1. Written confirmation from hotel management.
2. The verified Google Business Profile or owned OTA dashboard.
3. A documented contract with an approved partner, for partner-operated services.

Do not publish safari, tour, package, capacity, price, amenity, distance, or attraction claims until they meet this standard.

## SEO goals

### Near-term goals

- Own branded searches for `Mounts Edge Regency` and close name variations.
- Send search, Maps, social, and OTA visitors to a fast official website.
- Make contact, WhatsApp, and booking/enquiry conversion measurable.
- Ensure consistent business information across Google and major OTAs.

### Growth goals

- Compete for commercial local searches such as `hotel in Mahiyangana`, `hotel in Hasalaka`, `wedding venue Mahiyangana`, and genuine day-out/package searches.
- Build useful destination authority for attractions relevant to the hotel location.
- Improve the eligibility of property-owned images for Google Images.
- Make Mounts Edge a clear, factual entity that search engines and AI answer systems can understand and cite.

## Canonical entity policy

Use one management-approved version of the following information everywhere:

| Field | Required decision |
| --- | --- |
| Business name | `Mounts Edge Regency` unless management confirms a legal change |
| Postal address | Confirm exact legal/postal format before publication |
| Map pin | Verify against the physical property entrance |
| Primary phone | Confirm one public reservations number |
| WhatsApp | Confirm a monitored reservations number |
| Reservation email | Confirm a monitored official inbox |
| Primary URL | Select the final HTTPS domain before launch |

Apply these details to the website footer, contact page, schema, Google Business Profile, Facebook, Instagram, Booking.com, TripAdvisor, Agoda, Trip.com, and all other managed listings. Do not add location keywords to the Google Business Profile name.

## Phased roadmap

| Phase | Timing | Outcome | Status (2026-10-07) |
| --- | --- | --- | --- |
| 0. Business truth and content governance | Before implementation | Management-approved source of truth for all public hotel content | **Verified 2026-10-08** — signed source of truth; exact listing ownership and GBP execution remain Phase 3 operational follow-ups |
| 1. Technical SEO foundation | Weeks 1–2 | Crawlable, measurable, fast, correctly indexed site | Implemented and verified — defects fixed 2026-10-07; launch items remain (domain, GA4, Search Console) |
| 2. Commercial page optimization | Weeks 2–4 | Strong hotel, rooms, wedding, dining, gallery, contact, and experience pages | Core pass done 2026-10-07 — copy/FAQ synced to verified facts, placeholder rooms removed, per-event catering framing; detail pages and gallery alt-text open |
| 3. Local entity and reputation cleanup | Weeks 2–6, ongoing | Consistent Google/OTA profiles and ethical review operation | Checklist drafted (`LOCAL-LISTINGS.md`) — execution pending owner access |
| 4. Destination content cluster | Months 2–4 | Helpful Mahiyangana travel content and internal topical authority | Not started |
| 5. Image SEO | Starts at launch, ongoing | Discoverable, accurately described property and destination images | Started — 12 gallery images have unique factual alt text and image-sitemap captions; per-page OG images added (2026-10-08) |
| 6. Partner services and package expansion | Months 3–5, conditional | Legitimate safari, tour, or package pages only where real services exist | Started — Experiences page now carries a hotel-operated Tours, Transport & Day-Outs section with Service Enquiry conversion (2026-10-08); no fixed packages or published rates |
| 7. Authority and AI visibility | Months 3–12, ongoing | Strong third-party mentions, citations, and reliable entity signals | Not started |
| 8. Measurement and continuous improvement | Launch onward | Decisions based on Search Console, analytics, conversions, and reviews | Not started — GA4 config intentionally deferred to launch |

## Phase 0 — Business truth and content governance

**Objective:** create a verified content inventory before writing SEO copy or schema.

### Management input checklist

Collect and sign off on the following information:

- [ ] Exact postal address and postcode
- [ ] Google Maps share link and confirmation that the pin is exact
- [ ] Primary public reservations phone number
- [ ] WhatsApp number and responsible staff member
- [ ] Reservation email
- [x] Check-in and check-out times (2:00 PM / 12:00 PM noon; confirmed 2026-10-08)
- [ ] Current room inventory, names, bed configuration, capacity, bathroom details, amenities, accessible features, images, and pricing/enquiry policy
- [ ] Current wedding halls and outdoor spaces, capacity, event facilities, menus, package policy, parking, and approved imagery
- [ ] Dining hours, food offering, bar information, and reservation policy
- [ ] Pool availability, rules, opening hours, and safety policy
- [x] Day-out packages: no fixed packages active; customized arrangements available on request
- [x] Safaris/tours/transport/day-outs: hotel-operated (confirmed 2026-10-08)
- [x] Partner service review: no external partner services confirmed; the listed transport/tours/day-outs are hotel-operated and commission-free
- [ ] Cancellation, child, pet, smoking, parking, accessibility, and payment policies
- [x] Copyright/usage approval for all current photos and videos (owner-confirmed 2026-10-08)

### Dynamic content governance

The admin system remains the operational content source. Add or plan the following fields for content that can appear in Google:

| Content type | Required SEO fields |
| --- | --- |
| Room type / room | URL slug, SEO title, meta description, featured image, image alt text, publish state |
| Wedding hall / package | URL slug, SEO title, meta description, capacity, feature image, image alt text, publish state |
| Gallery image | Alt text, caption, content category, usage rights, publish state |
| Attraction / experience | Verified location, source/partner, travel time basis, SEO title, meta description, publish state |
| Package / offer | Valid-from date, expiry date, price currency, inclusions, exclusions, availability, publish state |

### Phase 0 acceptance criteria

Phase 0 is complete only when:

1. Management has approved the canonical business details.
2. Every public page claim can be traced to an approved source.
3. The content team knows which database values are placeholders versus live content.
4. The team has decided whether direct booking, enquiry-only, or a third-party booking engine is the conversion model.

## Phase 1 — Technical SEO foundation

**Objective:** make every public page crawlable, indexable, fast, and measurable.

**Implementation status (verified 7 October 2026):** the Laravel application now provides page-specific metadata, canonical URLs, homepage Hotel structured data, a dynamic `robots.txt`, page sitemap, database-backed image sitemap, optional GA4 loading, and conversion-event hooks. Site performance work completed separately (`PERFORMANCE-AUDIT.md`): home page payload 23.9 MB → 575 KB, upload-time optimisation, responsive WebP delivery, and cache headers. The production domain, `GA_MEASUREMENT_ID`, Search Console verification, deployment HTTPS enforcement, and final content verification still require launch access and management input.

### Verified implementation detail

- Metadata, canonicals, OG/Twitter tags: implemented for all 7 public routes in `app/Support/SeoMeta.php` and rendered in `resources/views/layouts/app.blade.php`. Single shared OG image, not per-page.
- Structured data: `@graph` with WebSite, Hotel (PostalAddress, ContactPoint), BreadcrumbList, and FAQPage. `Hotel` subsumes `LocalBusiness`; `GeoCoordinates` is not emitted — no verified lat/lng exists yet (blocked by Phase 0 map-pin confirmation).
- Sitemaps: page sitemap covers the 7 static routes; image sitemap is database-backed and gates room/hall imagery behind `SEO_CONTENT_VERIFIED` (correct while those rows are placeholders). Gallery images are always included.
- Admin pages carry `noindex, nofollow` (`components/admin-layout.blade.php`). Guest/auth pages (login, password reset) have no robots meta and rely only on the robots.txt disallow.
- Conversion events: see defect 2 below.

### Resolved defects (fixed and verified 2026-10-07)

1. **Stale `site_settings` row → fixed.** `database/migrations/2026_10_07_000001_sync_site_settings_with_business_truth.php` updates row id=1 to the owner-verified `BUSINESS-TRUTH.md` §1 values, so every environment gets the fix by running `php artisan migrate`. Verified: the live row, contact page, and Hotel schema all show the official email, WhatsApp, and full street address.
2. **Conversion events firing twice under different names → fixed.** Tracking now lives only in `resources/js/app.js` with one vocabulary (`generate_lead`, `contact_phone_click`, `contact_email_click`, `contact_whatsapp_click`, `contact_map_click`). The duplicate inline script was removed from the layout, and all `data-conversion` attributes renamed to the canonical names. Verified in the built bundle.
3. **Static `public/robots.txt` shadowing the dynamic route → fixed.** The static file was deleted; `SitemapController@robots` now serves, emitting an absolute sitemap URL. Verified live.
4. **Auth pages lacked a robots meta → fixed.** `layouts/guest.blade.php` (login, password reset, etc.) now carries `noindex, nofollow`.
5. **`$seo` undefined on pages using `<x-seo-intro>`/`<x-seo-faq>` (pre-existing, found during verification) → fixed.** Page views rendered before the layout computed `$seo`, causing a 500 on `/contact`, `/dining`, and other pages with visible SEO blocks. The view composer in `AppServiceProvider` now supplies `$seo` to the seven public page views. Verified: all eight public pages return 200 and the intro/FAQ blocks render.

### Minor, non-blocking: sitemap URLs now include a deploy-date `lastmod`; the image sitemap emits gallery captions; OG images are page-specific.

### Implementation requirements

- Unique page title and meta description for each public URL.
- Self-referencing canonical URL for indexable pages.
- Accurate Open Graph and Twitter metadata per page.
- HTTPS-only site with a single canonical host.
- `robots.txt` that permits public pages and blocks admin/private paths.
- Dynamic `sitemap.xml` containing indexable public pages only.
- Image sitemap for eligible website images.
- Helpful 404 response and permanent redirects for any renamed public URLs.
- Mobile-first layout and Core Web Vitals budget.
- Google Search Console and Google Analytics 4 configured at launch.
- Conversion events for enquiry form submission, phone click, WhatsApp click, email click, map click, and booking-engine click.

### Structured data

Generate structured data from management-approved database fields only:

- `Hotel` and `LocalBusiness` on the homepage.
- `Organization`, `PostalAddress`, `GeoCoordinates`, and `ContactPoint` where valid.
- `BreadcrumbList` on hierarchical public pages.
- `ImageObject` for important original images.
- `EventVenue` only for actual event facilities.
- `Offer` only for genuine active packages with clear terms.
- `FAQPage` only when the matching FAQs are visible to visitors.

Do not add fabricated review markup, aggregate ratings sourced from a platform without attribution, or markup for unavailable services.

## Phase 2 — Commercial page optimization

**Objective:** make the website the best source for people ready to enquire or stay.

**Implementation status (2026-10-07):** core pass done. The live database now holds only the four owner-verified rooms (placeholder Villa/Family rows removed); page metadata, intros, and FAQs on rooms, weddings, and dining carry the verified facts (room inventory, hall capacities, per-event catering, outside vendors welcome, dining hours, walk-ins); the wedding "packages" tab is reframed as menu examples; the dining signature-dish framing was softened to a menu-range claim; and the internal-link mesh was strengthened (gallery ↔ rooms/experiences, experiences ↔ gallery, dining ↔ weddings). Detail pages per room/hall and gallery alt-text work remain open.

### Core pages

| Page | Intent | Required content |
| --- | --- | --- |
| Home | Hotel in Mahiyangana / brand | Location, primary facilities, rooms, pool, dining, weddings, nearby experiences, trust, direct enquiry |
| Rooms hub | Accommodation | Real room categories, comparison, amenities, actual photos, enquiry flow |
| Room detail pages | Specific room intent | Capacity, beds, bathroom, amenities, view, photos, availability/enquiry CTA |
| Weddings hub | Wedding venue intent | Verified spaces, capacity, services, food, gallery, enquiry CTA |
| Wedding hall/package pages | Specific event intent | Only live halls/packages, inclusions, exclusions, capacity, images, enquiry CTA |
| Dining | Restaurant/dining intent | Cuisine, dining times, location, menu/reservation guidance |
| Gallery | Visual discovery | Categorized and accurately captioned rooms, food, pool, weddings, grounds |
| Experiences | Local travel intent | Curated nearby experiences, not unsupported service claims |
| Contact and directions | Conversion/local intent | Canonical NAP, map, transport/directions, phone, WhatsApp, enquiry form |

Keep the existing public URLs unless there is a strong SEO or user-experience reason to change them. If a URL changes after launch, implement a permanent redirect from the old address.

### On-page rules

- One clear H1 per page.
- Write for a guest's real decision, not keyword repetition.
- Include natural references to Gurulupotha, Hasalaka, and Mahiyangana where relevant.
- Use internal links among rooms, weddings, dining, contact, packages, and destination guides.
- Include a relevant conversion CTA on every commercial page.
- Refresh pages whenever the hotel changes a room, hall, package, or policy.

## Phase 3 — Local entity, OTA, and reputation cleanup

**Objective:** align third-party platforms with the official website and real guest experience.

### Profile priorities

1. Google Business Profile
2. Booking.com
3. TripAdvisor
4. Agoda
5. Trip.com
6. Facebook and Instagram
7. Other OTA/directory profiles found during audit

### Google Business Profile checklist

- Preserve the accurate name `Mounts Edge Regency`.
- Verify the address, pin, phone, hours, and applicable categories.
- Add the final official website URL with UTM parameters after launch.
- Complete genuine amenities, services, and hotel attributes.
- Upload high-quality current photos and short walkthrough videos.
- Respond to reviews consistently and professionally.
- Answer genuine customer questions with facts.
- Publish real updates, seasonal offers, wedding showcases, and property news.

### Review operation

- Invite all eligible guests to leave an honest review after their stay.
- Do not buy reviews, incentivize reviews, review-gate, or ask only satisfied guests.
- Respond to positive and negative reviews promptly.
- Treat repeated bathroom, cleanliness, comfort, or maintenance feedback as operational work.
- Use positive, recurring review themes—such as pool, family, nature, food, and service—only if they remain true.

## Phase 4 — Mahiyangana destination authority

**Objective:** earn long-tail traffic by helping visitors plan a real stay and trip.

Start with an experience hub and build guides only for places the hotel can describe accurately:

```text
/experiences
/things-to-do-in-mahiyangana
/mahiyangana-temple
/sorabora-wewa
/18-bends
/kaluwa-watuna-ella
/dambana
/mahiyangana-travel-guide
/mahiyangana-weekend-itinerary
```

Each guide should include accurate directions, practical timing, expectations, sources where needed, original/licensed images, a clear relationship to the hotel, and relevant links back to rooms, dining, and enquiries.

Never state that an attraction is owned by, inside, or immediately adjacent to the hotel unless that is true.

## Phase 5 — Image SEO

**Objective:** strengthen Google Images visibility for property-owned visual assets and build correct contextual visibility for nearby locations.

### Image standards

- Use descriptive filenames, for example `mounts-edge-regency-pool-gurulupotha.webp`.
- Write unique, factual alt text.
- Add captions when they help visitors understand the scene.
- Serve responsive WebP/AVIF versions.
- Lazy-load non-critical images; preload only the true LCP image.
- Include eligible images in the image sitemap and relevant structured data.
- Prefer original photography and retain documented usage rights.

For nearby attraction images, make the context explicit, for example: `Sorabora Wewa, a nearby attraction visitors can reach from Mounts Edge Regency`. Do not imply hotel ownership or a false location.

## Phase 6 — Partner services and packages

**Objective:** create high-value service pages without misleading visitors or search engines.

Create safari, wildlife, tour, trip-package, or transport pages only when the hotel directly operates the service or has a documented partner arrangement.

Partner pages must identify the partner, booking method, cancellation terms, approximate travel logistics, safety/responsible-tourism notes, and whether the hotel earns a commission or only provides a recommendation.

If no commercial service exists, publish an informational guide instead of a sales page.

## Phase 7 — Authority and AI visibility

**Objective:** make Mounts Edge consistently verifiable beyond its own website.

Build authority through genuine, relevant activity:

- Eligible Sri Lankan tourism and local business listings.
- Accurate OTA and travel-directory profiles.
- Real wedding vendor, photographer, planner, and local-event relationships.
- Named safari/tour partners where applicable.
- Local travel publications and editorial coverage.
- Original wedding stories, guest content, videos, and destination guides.
- Useful, factually maintained FAQs and policy pages.

AI systems may use a mixture of first-party pages, Google data, OTAs, reviews, travel sites, and citations. Schema helps them understand facts, but it does not guarantee recommendations. Consistent facts, good guest experience, useful content, and third-party validation are the durable strategy.

## Phase 8 — Measurement and continuous improvement

**Objective:** choose future work based on data rather than assumptions.

### Weekly monitoring

- Search Console index coverage and query impressions.
- Branded search visibility.
- Enquiry submissions, WhatsApp clicks, phone clicks, and map clicks.
- Google Business Profile performance.
- New reviews and response time.
- Broken links, 404s, and slow pages.

### Monthly monitoring

- Rankings by country/device for priority queries.
- Top landing pages and conversion rate.
- Room/wedding/package content freshness.
- Local citation accuracy.
- Image search impressions.
- Competitor changes in Maps, reviews, content, and offers.

## Success milestones

| Period | Expected outcome |
| --- | --- |
| Launch–30 days | Official site indexed, brand searches owned, analytics working, GBP linked, core pages live |
| 30–90 days | Long-tail visibility for Gurulupotha/Hasalaka, rooms, pool, family stays, and genuine wedding terms |
| 3–6 months | Strong commercial and destination content coverage; growing local citations and image visibility |
| 6–12 months | Competitive visibility for broader Mahiyangana hotel/travel terms and improved AI-answer eligibility |

## Immediate next action

1. ~~Fix the three Phase 1 defects~~ **Done 2026-10-07** (plus the `$seo` page-view error and auth noindex found along the way).
2. ~~Continue **Phase 0**~~ **Done 2026-10-08** — business truth signed by the hotel manager; canonical room inventory, check-out time, hotel-operated services, photo rights, listing URLs, and review SLA recorded.
3. At launch: set `APP_URL=https://mountsedgeregency.lk`, set `GA_MEASUREMENT_ID`, enable `SEO_CONTENT_VERIFIED` once content is approved, submit the sitemap in Search Console, and execute `LOCAL-LISTINGS.md`.
