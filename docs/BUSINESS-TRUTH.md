# Mounts Edge Regency — Business Truth (Phase 0 Source of Truth)

**Status:** MOSTLY VERIFIED — contact + rooms + weddings + dining (incl. hours) + attractions all owner-confirmed 2026-10-01…07; remaining TODOs: check-out time, GBP link, parking count, commission disclosure, §6 policies, listings
**Last updated:** 2026-10-07
**Owner:** Hotel management
**Related:** `docs/SEO-PLAN.md` Phase 0

> This file is the ONLY approved source for public business facts.
> Website copy, schema, GBP, OTAs, Facebook/Instagram must match this file exactly.
> Seeded dev-database values are placeholders — do NOT publish unless they match this file.
> Fill every `TODO` then change Status to `VERIFIED YYYY-MM-DD, signed by: ____`.

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
| Check-in / Check-out | Check-in 2:00 PM confirmed; check-out TODO | owner 2026-10-01 | Contact page shows check-in only |
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
four rooms. **Current owner-confirmed inventory 2026-10-07 (site user, relaying
owner's current list): all rooms are Deluxe-grade plus a Family Suite — no
Standard rooms.** Site shows room names/capacities only; rates are recorded
here for internal reference and must NOT be published on the site (enquiry +
OTA "Show prices" model unchanged).

Each room has four rate tiers (owner's list, 2026-10-07) — likely occupancy/
meal-plan variants; tier names not specified. Internal reference only:

| Room | Guests | Tier 1 | Tier 2 | Tier 3 | Tier 4 |
|---|---|---|---|---|---|
| Deluxe Single | 1 | 9,000 | 11,700 | 15,600 | 18,500 |
| Deluxe Double | 2 | 10,900 | 14,200 | 20,600 | 24,000 |
| Deluxe Triple | 3 | 12,400 | 15,700 | 25,600 | 30,500 |
| Deluxe Family | 4 | 14,900 | 19,200 | 28,600 | 35,000 |
| Family Suite | 8 | 20,500 | 27,200 | 40,600 | 53,000 |

All rates LKR per night; "Room only" is tier 1. Publish? Y for names/capacity/
type; N for prices. Bed configurations from the OTA list apply where known:
Deluxe Single 1 large double bed, Deluxe Double 2 large double beds, Deluxe
Triple 3 beds (assumed — confirm), Deluxe Family 4 large double beds, Family
Suite sleeps 8 (bed configuration TODO — confirm).

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
Commission / partner disclosure needed? — idk → TODO: confirm whether the
hotel earns commission from any caterer/decorator/partner before publishing
any partner page (plan Phase 6 requires disclosure).

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

Still TODO:

- Pool: size/timing/rules/lifeguard? TODO
- Family / kids? TODO (ages, extra beds)
- Cancellation / payment timing / ID policy: TODO (needed for FAQ + schema)
- Check-out time: TODO (check-in 2:00 PM confirmed)

Google Business Profile: **no access yet** (owner 2026-10-07). Commission on partners: owner does not know — keep TODO; do not publish any partner page until confirmed.

---

## 7. Distances & Attractions (only what you can prove)

Owner-confirmed 2026-10-07: all attraction data currently on the site is
correct. Values below are the published site values, now owner-verified.

| Attraction | Distance/time + source | Transport offered? | Guide page allowed? |
|---|---|---|---|
| Mahiyangana Raja Maha Viharaya | 5 min drive (owner-confirmed) | TODO — confirm with owner | Y |
| Sorabora Wewa | 15 min drive (owner-confirmed) | TODO | Y |
| Rathna Ella (Hasalaka) | 45 min drive (owner-confirmed) | TODO | Y |
| 18 Bends / Dahata Wanguwa | 30 min drive (owner-confirmed) | TODO | Y |
| Dambana / Vedda village | 40 min drive (owner-confirmed) | TODO | Y |
| Seetha Kotuwa | 20 min drive (owner-confirmed) | TODO | Y |
| Dunhinda Fall | 1.5 hours drive (owner-confirmed) | TODO | Y |
| Maha Oya Hot Springs | 1 hour drive (owner-confirmed) | TODO | Y |
| Mawaragala Forest Monastery | 30 min drive (owner-confirmed) | TODO | Y |
| Victoria Dam | 1.5 hours drive (owner-confirmed) | TODO | Y |
| Randenigala Dam | 1 hour drive (owner-confirmed) | TODO | Y |
| Meemure | 2 hours drive (owner-confirmed) | TODO | Y |
| Riverston | 2 hours drive (owner-confirmed) | TODO | Y |
| Wasgamuwa National Park | 1 hour drive (owner-confirmed) | TODO | Y |
| Maduru Oya National Park | 1.5 hours drive (owner-confirmed) | TODO | Y |

Image rule: `Sorabora Wewa, a nearby attraction visitors can reach from Mounts Edge Regency` — do NOT imply ownership.

Safari/tour sales page allowed ONLY if hotel-operated OR documented partner (name, booking, cancellation, safety, commission disclosed). Else info-guide only. Partner docs: TODO — owner has not confirmed any transport/arrangement service; the site must NOT claim the hotel operates tours or transport.

---

## 8. Listings, social, reviews

| Platform | URL / handle | NAP matches §1? | Owner |
|---|---|---|---|
| Google Business Profile | TODO | [ ] | TODO |
| Booking.com | TODO | [ ] | TODO |
| TripAdvisor | TODO | [ ] | TODO |
| Agoda / Trip.com | TODO | [ ] | TODO |
| Facebook / Instagram | TODO | [ ] | TODO |
| Review reply owner + SLA | TODO e.g. `___ replies within 48h` | — | TODO |

Current Google facts (30 Sep 2026 screenshot): `4.0 / 348 reviews / 3-star / 055 225 6500 / Kandy Rd, Gurulupotha` — re-verify at publish.

---

## 9. Sign-off

- [ ] §1 canonical entity confirmed (contact facts done 2026-10-01/02; check-out time and GBP link remain)
- [ ] §2 SiteSetting + env ready to update (row synced 2026-10-07 by migration; `APP_URL`/GA4 at launch)
- [x] §3 rooms confirmed (owner 2026-10-07: 5 rooms, all Deluxe + Family Suite; rates recorded internally, not published)
- [x] §4 weddings — owner-confirmed 2026-10-07: capacities, areas, power backup, parking, bridal room, catering, decoration, outside vendors; package validity dates and commission disclosure still open
- [x] §5 dining — owner-confirmed 2026-10-07: no restaurant name, cuisines Sri Lankan + international, walk-ins OK, bar YES, hours 6:30 AM–10:00 PM / bar 5:00 PM–11:00 PM, no signature dishes
- [ ] §6 policies confirmed (parking free, WiFi free for all, power backup with rooms, all payment methods — done 2026-10-07; pool, family, cancellation, check-out still open)
- [x] §7 distances — owner-confirmed 2026-10-07: all attraction data on the site is correct; transport offered still open
- [ ] §8 listings owner assigned
- [ ] `SeoMeta.php` copy + `hotelSchema()` + image-sitemap filter updated to this file
- [ ] `docs/SEO-PLAN.md` status updated to `Phase 0 verified YYYY-MM-DD`

Answered/confirmed by: hotel owner (via site user), 2026-10-07.

Signed: ________________ Date: __________ Role: __________
