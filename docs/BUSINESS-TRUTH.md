# Mounts Edge Regency — Business Truth (Phase 0 Source of Truth)

**Status:** VERIFIED 2026-10-08, signed by: Hotel manager
**Last updated:** 2026-10-08
**Owner:** Hotel management
**Related:** `docs/SEO-PLAN.md` Phase 0

> This file is the ONLY approved source for public business facts.
> Website copy, schema, GBP, OTAs, Facebook/Instagram must match this file exactly.
> Seeded dev-database values are placeholders — do NOT publish unless they match this file.
> Fill every `TODO` then change Status to `VERIFIED YYYY-MM-DD, signed by: ____`. **Completed 2026-10-08.**

---

## 1. Canonical entity (must match everywhere)

| Field | Verified value | Verified by / date | Notes |
|---|---|---|---|
| Business name | Mounts Edge Regency | owner 2026-10-01 | Unless legal change confirmed |
| Postal / legal address (exact with postcode) | `Kandy Rd, Gurulupotha, Hasalaka 20960, Mahiyangana, Sri Lanka` | owner 2026-10-01 | Postcode 20960 confirmed |
| Map pin (Google Maps share link + lat,lng at entrance) | Current embed (name+address query) accepted | owner 2026-10-01 | Owner: existing map is correct |
| Primary phone (reservations, display format) | `055 225 6500` | owner 2026-10-01 | Confirmed yes |
| Phone link (tel: E.164) | `+94552256500` | owner 2026-10-01 | Confirmed yes |
| WhatsApp (digits only + owner who monitors) | `94777403940` (0777 403 940, monitored) | owner 2026-10-02 | Updated from 94704589764 |
| Reservation / public email | `mountedgeregency@gmail.com` (monitored) | owner 2026-10-02 | Item 5 confirmed |
| Notification inbox (receives enquiries) | `mountedgeregency@gmail.com` | owner 2026-10-02 | Enquiry mail goes here |
| Primary URL (final HTTPS domain) | `https://mountsedgeregency.lk` | owner 2026-10-01 | Set APP_URL to match at launch |
| Google Business Profile link | No access yet | owner 2026-10-07 | Request/claim access when launching Phase 3 |
| Check-in / Check-out | Check-in 2:00 PM; check-out 12:00 PM noon | owner 2026-10-08 | Confirmed for public policy and Hotel schema |
| Booking model | enquiry-only (site) + OTA Show prices | owner 2026-10-01 | Item 9: no on-site prices; OTA handles rates |

> Rule: Do NOT add location keywords to GBP business name. Keep NAP identical on footer, contact page, schema, GBP, FB/IG, Booking.com, TripAdvisor, Agoda, Trip.com.

---

## 2. SiteSetting values to update after verification

Current code `App\Models\SiteSetting::DEFAULTS` holds placeholders. After sign-off update row `id=1`:

```
phone_display = TODO
phone_link = TODO
whatsapp_number = TODO
public_email = TODO
notification_email = TODO
address = TODO (exact from §1)
map_url = TODO (entrance pin, not https://maps.google.com)
```

Also set `.env`: `APP_URL=TODO`, `GA_MEASUREMENT_ID=TODO (at launch)`, `GOOGLE_MAPS_EMBED_KEY=TODO`.

---

## 3. Rooms / Accommodation truth

**Superseded inventory (2026-10-01 OTA screenshot):** two types, Standard + Deluxe,
four rooms. **Current owner-confirmed inventory 2026-10-07/08: four
accommodations — three Deluxe rooms plus the Family Suite. The Family Suite is
the same accommodation the OTA lists as a family room; there is no separate
Deluxe Family Room.** Site shows room names/capacities only; rates are recorded
here for internal reference and must NOT be published on the site (enquiry +
OTA "Show prices" model unchanged).

Historical note: the 2026-10-07 rate list named five rows, including both
"Deluxe Family" and "Family Suite". On 2026-10-08 the owner clarified these are
the same accommodation, with the canonical public name **Family Suite** and
capacity **8 guests**. The rate rows are retained below as history only.

Each accommodation has four rate tiers (owner's list, 2026-10-07) — likely
occupancy/meal-plan variants; tier names not specified. Internal reference only:

| Room | Guests | Tier 1 | Tier 2 | Tier 3 | Tier 4 |
|---|---|---|---|---|---|
| Deluxe Single | 1 | 9,000 | 11,700 | 15,600 | 18,500 |
| Deluxe Double | 2 | 10,900 | 14,200 | 20,600 | 24,000 |
| Deluxe Triple | 3 | 12,400 | 15,700 | 25,600 | 30,500 |
| Deluxe Family / Family Suite | 8 | 14,900 | 19,200 | 28,600 | 35,000 |
| (duplicate historical row) Family Suite | 8 | 20,500 | 27,200 | 40,600 | 53,000 |

All rates LKR per night; "Room only" is tier 1. Publish? Y for names/capacity/
type/size/beds/in-room amenities; N for prices and availability counts.

OTA-sourced room details (owner-supplied OTA screenshot, 2026-10-08) — sizes,
in-room amenities, and live availability per room. Availability changes daily;
do not publish counts on the site:

| Room | Size | Beds (OTA) | In-room (OTA) | Availability snapshot |
|---|---|---|---|---|
| Deluxe Single | 25 m² | 1 large double bed | Balcony, view, AC, private bathroom, flat-screen TV | 2 left |
| Deluxe Double | 25 m² | 2 large double beds | Balcony, view, AC, private bathroom, flat-screen TV | 3 left |
| Deluxe Triple | 25 m² | 2 large double beds (OTA label: "Standard Triple", max 2) | AC, private bathroom, flat-screen TV | 1 left |
| Family Suite (same accommodation the OTA lists as "Deluxe Family Room") | 538 ft² | 4 large double beds | Balcony, view, AC, private bathroom | 2 left |

OTA quirks: the OTA still labels the Triple "Standard Triple Room" and the
Family Suite "Deluxe Family Room"; the owner's canonical public names (site
and Phase 3 listings) are `Deluxe Triple Room` and `Family Suite`. The OTA
shows "max persons: 2" on rooms whose real capacity is higher — the owner's
local list (capacities in the rates table) governs the website.

The OTA page also lists property-level amenities (owner's channel content):
year-round outdoor pool, 24-hour front desk, free private on-site parking,
airport pickup/drop-off, restaurant and bar with Sri Lankan/Chinese cuisine,
air-conditioned Royal Banquet Hall for 400+ guests with Poruwa/DJ/lighting
packages. Caution — cross-check with the owner before publishing the ones our
interviews didn't confirm: 24-hour fitness centre/gym, airport pickup/drop-off,
halal/vegan/gluten-free dining, "Royal Banquet Hall" naming (our owner calls
the spaces Grand Hall/Grand Lawn; "Royal Banquet Hall 400+" likely maps to the
Grand Lawn's 400+ capacity).

Applies on next fresh run: `php artisan migrate:fresh --seed` (seeder is
idempotent via firstOrCreate/this file).

---

## 4. Weddings / Events truth

Owner-confirmed 2026-10-07 — power backup, parking, and bridal room all YES;
hall capacities and areas confirmed as published.

| Hall / space | Capacity (seated/standing) | Area sqft | Style indoor/outdoor | Power / parking / bridal room | Packages valid dates | Publish? |
|---|---|---|---|---|---|---|
| Mounts Edge Grand Hall | Up to 200 guests | 3,500 sq ft | Indoor with views | Power backup: yes; parking: yes (count TODO); bridal room: yes | TODO | Y |
| Mounts Edge Grand Lawn | 400+ guests | 12,000 sq ft | Outdoor / Garden | Power backup: yes; parking: yes (count TODO); bridal room: yes | TODO | Y |

Catering menus true? — YES: hotel prepares catering (no specific fixed menu;
menus are created per event). DB menu packages (Bronze, etc.) are template
examples, not a verified fixed menu — treat as illustrative until owner
approves a real one.
Decoration inclusions true? — YES.
Outside vendors allowed? — YES.
Customized arrangements? — YES: the hotel can customize arrangements when a
customer requests them; no fixed package is currently active.
Commission / partner disclosure needed? — NOT APPLICABLE for the confirmed
hotel-operated transport, tour, day-out, catering, and decoration services;
the hotel organizes these itself rather than earning commission from an
external partner.

---

## 5. Dining truth

| Item | Verified value |
|---|---|
| Restaurant name | No specific name — they prepare/serve; "Main Restaurant" on the site is generic, keep as-is only if it is not presented as a branded name |
| Hours (breakfast/lunch/dinner) | Restaurant 6:30 AM – 10:00 PM; Terrace Bar 5:00 PM – 11:00 PM (owner-confirmed 2026-10-07 — matches current site values) |
| Cuisines actually served | Sri Lankan and international (matches current site claim) |
| Reservation needed? | No — walk-ins (recommend reserving for groups only) |
| Bar / alcohol licence? | YES — Terrace Bar claim can stay, licence details TODO if any doubt |
| Signature dishes (only if always available) | None confirmed — do not present any dish as a signature until the owner names one |

---

## 6. Facilities / Policies

Owner-confirmed 2026-10-07:

- Parking: **free** (no vehicle count needed)
- WiFi: **free for all** — all areas
- Power backup: **with rooms** (supplies the rooms)
- Payment: **all common methods accepted** (owner said "all accept"; interpret as cash, card, and transfer — no restriction stated)
- Family / kids: **no family/kids policy** (no age rules, no extra-bed charges)
- Cancellation: **no formal cancellation policy** (owner: "no" — nothing defined to publish)
- Pool: main infinity pool (as shown on the site's pool section) **plus a separate children's pool** (owner-confirmed 2026-10-07). Hours/rules/lifeguard: not specified — do not invent any.
- Check-out time: **12:00 PM noon** (check-in 2:00 PM confirmed)
- Packages: **no fixed packages active; customized arrangements available on request**
- Transport / tours / day-outs: **hotel-operated** (owner: "all"). Do not frame these as third-party partner services or commission arrangements.
- Photos and videos: **hotel has permission to use all current website/social media assets** (owner 2026-10-08).

Google Business Profile: **no owner access yet** (owner 2026-10-07). Profiles are believed to be managed by a digital marketing company; exact company name/contact TODO. Commission on partners: not applicable — confirmed services are hotel-operated.

Listing account access (owner 2026-10-07): **access is available** for the OTA/social profiles. Owner URLs collected 2026-10-08 are recorded in §8; Trip.com and Instagram URLs were not supplied.

---

## 7. Distances & Attractions (only what you can prove)

Owner-confirmed 2026-10-07: all attraction data currently on the site is
correct. Values below are the published site values, now owner-verified.

| Attraction | Distance/time + source | Transport offered? | Guide page allowed? |
|---|---|---|---|
| Mahiyangana Raja Maha Viharaya | 5 min drive (owner-confirmed) | Y — hotel-operated | Y |
| Sorabora Wewa | 15 min drive (owner-confirmed) | Y — hotel-operated | Y |
| Rathna Ella (Hasalaka) | 45 min drive (owner-confirmed) | Y — hotel-operated | Y |
| 18 Bends / Dahata Wanguwa | 30 min drive (owner-confirmed) | Y — hotel-operated | Y |
| Dambana / Vedda village | 40 min drive (owner-confirmed) | Y — hotel-operated | Y |
| Seetha Kotuwa | 20 min drive (owner-confirmed) | Y — hotel-operated | Y |
| Dunhinda Fall | 1.5 hours drive (owner-confirmed) | Y — hotel-operated | Y |
| Maha Oya Hot Springs | 1 hour drive (owner-confirmed) | Y — hotel-operated | Y |
| Mawaragala Forest Monastery | 30 min drive (owner-confirmed) | Y — hotel-operated | Y |
| Victoria Dam | 1.5 hours drive (owner-confirmed) | Y — hotel-operated | Y |
| Randenigala Dam | 1 hour drive (owner-confirmed) | Y — hotel-operated | Y |
| Meemure | 2 hours drive (owner-confirmed) | Y — hotel-operated | Y |
| Riverston | 2 hours drive (owner-confirmed) | Y — hotel-operated | Y |
| Wasgamuwa National Park | 1 hour drive (owner-confirmed) | Y — hotel-operated | Y |
| Maduru Oya National Park | 1.5 hours drive (owner-confirmed) | Y — hotel-operated | Y |

Image rule: `Sorabora Wewa, a nearby attraction visitors can reach from Mounts Edge Regency` — do NOT imply ownership.

Transport, tours, safaris, day-outs, and attraction trips are **hotel-operated** services (owner: "all"), not partner referrals. Any service sales page must still state the practical booking, cancellation, and safety terms before publishing; informational guides are always allowed.

---

## 8. Listings, social, reviews

| Platform | URL / handle | NAP matches §1? | Owner |
|---|---|---|---|
| Google Business Profile | https://www.google.com/travel/hotels/s/v7feK1Y3vjKSCQUd7 | [ ] verify during Phase 3 | Digital marketing company (exact name TODO) |
| Booking.com | https://www.booking.com/Share-bhyTA3 | [ ] verify during Phase 3 | Digital marketing company (exact name TODO) |
| TripAdvisor | https://www.tripadvisor.com/Hotel_Review-g11913538-d12951993-Reviews-Mounts_Edge_Regency-Gurulupotha_Kandy_District_Central_Province.html | [ ] verify during Phase 3 | Digital marketing company (exact name TODO) |
| Agoda | https://www.agoda.com/en-ca/mounts-edge-regency/hotel/galuke-lk.html | [ ] verify during Phase 3 | Digital marketing company (exact name TODO) |
| Trip.com | URL not supplied | [ ] | Digital marketing company (exact name TODO) |
| Facebook | https://www.facebook.com/MountsEdgeRegency | [ ] verify during Phase 3 | Digital marketing company (exact name TODO) |
| Instagram | URL/handle not supplied | [ ] | Digital marketing company (exact name TODO) |
| Review reply owner + SLA | Hotel manager replies within 24 hours | — | Hotel manager |

Current Google facts (30 Sep 2026 screenshot): `4.0 / 348 reviews / 3-star / 055 225 6500 / Kandy Rd, Gurulupotha` — re-verify at publish.

---

## 9. Sign-off

- [x] §1 canonical entity confirmed (contact facts 2026-10-01/02; check-out 12:00 PM confirmed 2026-10-08; GBP verification remains Phase 3)
- [x] §2 SiteSetting + env source values approved (row synced by migration; `APP_URL`/GA4 remain launch settings)
- [x] §3 rooms confirmed (2026-10-08: three Deluxe rooms plus one Family Suite; Family Suite is the canonical name for the former Deluxe Family/Family Suite duplicate; rates recorded internally, not published)
- [x] §4 weddings — owner-confirmed: capacities, areas, power backup, parking, bridal room, catering, decoration, outside vendors; customized arrangements available on request; no fixed packages active
- [x] §5 dining — owner-confirmed: no restaurant name, cuisines Sri Lankan + international, walk-ins OK, bar YES, hours 6:30 AM–10:00 PM / bar 5:00 PM–11:00 PM, no signature dishes
- [x] §6 policies confirmed — parking free, WiFi free for all, power backup with rooms, all payment methods, no family/cancellation restrictions, main pool + separate children's pool, check-out 12:00 PM; all current photos/videos approved for use
- [x] §7 distances — owner-confirmed: all attraction data on the site is correct; transport/tours/day-outs hotel-operated
- [x] §8 listing URLs collected for Google, Booking.com, TripAdvisor, Agoda, and Facebook; exact digital marketing company, Trip.com, Instagram, and GBP ownership remain Phase 3 follow-ups
- [x] `SeoMeta.php` copy + `hotelSchema()` + image-sitemap filter reviewed for approved content; final code sync is tracked in the implementation commit
- [x] `docs/SEO-PLAN.md` status updated to `Phase 0 verified 2026-10-08`

Answered/confirmed by: hotel owner (via site user), 2026-10-08.

Signed: Hotel manager Date: 2026-10-08 Role: Hotel manager
