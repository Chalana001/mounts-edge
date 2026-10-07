<?php

namespace App\Support;

use App\Models\SiteSetting;
use Illuminate\Http\Request;

class SeoMeta
{
    private const DEFAULT_DESCRIPTION = 'Mounts Edge Regency is a hotel on Kandy Rd, Gurulupotha near Hasalaka and Mahiyangana, Sri Lanka, for stays, dining, weddings, celebrations, and local experiences.';

    private const HOME_TITLE = 'Hotel in Mahiyangana, Sri Lanka | Mounts Edge Regency';

    /**
     * Return page-specific metadata without relying on seeded room, hall, or
     * package records. Those facts become public only after Phase 0 content
     * verification and dynamic detail pages are introduced.
     *
     * @return array{title: string, description: string, canonical: string, image: string, h1: string, intro: string, faq: array<int, array{q: string, a: string}>, structuredData: array<string, mixed>|null}
     */
    public static function forRequest(Request $request, SiteSetting $settings): array
    {
        $routeName = $request->route()?->getName();
        $page = self::pages()[$routeName] ?? self::fallbackPage();

        return [
            'title' => $page['title'],
            'description' => $page['description'],
            'canonical' => $request->url(),
            'image' => self::openGraphImageUrl(),
            'h1' => $page['h1'],
            'intro' => $page['intro'],
            'faq' => $page['faq'],
            'structuredData' => self::structuredData($routeName, $page, $request, $settings),
        ];
    }

    /** @return array<string, array{title:string,description:string,h1:string,intro:string,faq:array<int,array{q:string,a:string}>}> */
    private static function pages(): array
    {
        return [
            'home' => [
                'title' => self::HOME_TITLE,
                'description' => 'Stay at Mounts Edge Regency on Kandy Rd, Gurulupotha near Hasalaka and Mahiyangana, Sri Lanka, with dining, weddings, celebrations, and a peaceful mountain setting.',
                'h1' => 'Hotel in Gurulupotha, Near Mahiyangana',
                'intro' => 'Mounts Edge Regency is a hotel on Kandy Rd, Gurulupotha, Hasalaka 20960, near Mahiyangana, for quiet stays, weddings, dining, and day-outs.',
                'faq' => [
                    ['q' => 'Where is Mounts Edge Regency located?', 'a' => 'Mounts Edge Regency is on Kandy Rd, Gurulupotha, near Hasalaka and Mahiyangana, Sri Lanka. See the contact page for the map and directions.'],
                    ['q' => 'How do I book a stay or event?', 'a' => 'Send an enquiry through the contact page, call 055 225 6500, or message us on WhatsApp. The team confirms availability and arrangements.'],
                ],
            ],
            'luxury-stay' => [
                'title' => 'Rooms & Accommodation in Mahiyangana | Mounts Edge Regency',
                'description' => 'Deluxe single, double, triple, and family rooms plus a Family Suite at Mounts Edge Regency in Gurulupotha near Mahiyangana. Enquire for availability.',
                'h1' => 'Rooms & Accommodation Near Mahiyangana',
                'intro' => 'Stay at Mounts Edge Regency in Gurulupotha, Hasalaka 20960, near Mahiyangana. Choose from Deluxe single, double, triple, and family rooms, or the Family Suite for up to 8 guests — enquire for availability and rates.',
                'faq' => [
                    ['q' => 'How do I check room availability?', 'a' => 'Use the contact page enquiry form with your dates and guests, or call 055 225 6500. The team confirms availability and rates.'],
                    ['q' => 'What room types are available?', 'a' => 'Deluxe Single for 1 guest, Deluxe Double for 2, Deluxe Triple for 3, Deluxe Family for 4, and a Family Suite sleeping up to 8 guests.'],
                    ['q' => 'Is WiFi and parking free?', 'a' => 'Yes. WiFi is free in all areas and parking is free for guests. Rooms also have power backup.'],
                ],
            ],
            'weddings' => [
                'title' => 'Wedding Venue in Mahiyangana | Mounts Edge Regency',
                'description' => 'Plan your wedding at Mounts Edge Regency in Gurulupotha near Mahiyangana — an indoor hall for up to 200 guests, an outdoor lawn for 400+, in-house catering, and outside vendors welcome.',
                'h1' => 'Wedding Venue Near Mahiyangana',
                'intro' => 'Celebrate at Mounts Edge Regency in Gurulupotha, Hasalaka 20960, near Mahiyangana. Choose the Grand Hall for up to 200 guests or the Grand Lawn for 400+ — with in-house catering, decoration, power backup, parking, and a bridal room. Outside vendors are welcome.',
                'faq' => [
                    ['q' => 'How do I enquire about a wedding date?', 'a' => 'Send a wedding enquiry with your date and guest count through the contact page, or call 055 225 6500. The team confirms availability and packages.'],
                    ['q' => 'What capacities do the wedding spaces have?', 'a' => 'The Grand Hall seats up to 200 guests indoors (3,500 sq ft) and the Grand Lawn hosts 400+ guests outdoors (12,000 sq ft).'],
                    ['q' => 'Can we bring our own caterer or decorator?', 'a' => 'Yes. Outside vendors are welcome, and the hotel also prepares in-house catering and decoration — menus are planned per event.'],
                ],
            ],
            'dining' => [
                'title' => 'Dining in Mahiyangana | Mounts Edge Regency',
                'description' => 'Sri Lankan and international dining at Mounts Edge Regency, open daily 6:30 AM–10:00 PM, with The Terrace Bar from 5:00 PM. Walk-ins welcome; groups can reserve.',
                'h1' => 'Dining Near Mahiyangana',
                'intro' => 'Dine at Mounts Edge Regency in Gurulupotha, Hasalaka 20960, near Mahiyangana — Sri Lankan and international flavours in a relaxed mountain setting. The restaurant is open daily 6:30 AM–10:00 PM and The Terrace Bar from 5:00 PM. Walk-ins are welcome; reserving is recommended for groups.',
                'faq' => [
                    ['q' => 'Do I need to reserve a table?', 'a' => 'No reservation is needed — walk-ins are welcome. For larger groups and weekends, reserving through the contact page or 055 225 6500 is recommended.'],
                    ['q' => 'What are the dining hours?', 'a' => 'The restaurant serves daily from 6:30 AM to 10:00 PM, and The Terrace Bar is open from 5:00 PM to 11:00 PM.'],
                ],
            ],
            'experiences' => [
                'title' => 'Things to Do Near Mahiyangana | Mounts Edge Regency',
                'description' => 'Explore nature, culture, and nearby attractions around Mahiyangana from Mounts Edge Regency in Gurulupotha.',
                'h1' => 'Things to Do Near Mahiyangana',
                'intro' => 'Based in Gurulupotha, Hasalaka 20960, near Mahiyangana, Mounts Edge Regency is a handy base for temples, lakes, viewpoints, and village life.',
                'faq' => [
                    ['q' => 'Can the hotel help plan a day-out?', 'a' => 'Yes. Contact the team with your dates and interests and they will help with directions, timing, and local arrangements.'],
                ],
            ],
            'gallery' => [
                'title' => 'Hotel Gallery in Mahiyangana | Mounts Edge Regency',
                'description' => 'View rooms, celebrations, dining, and the grounds at Mounts Edge Regency in Gurulupotha near Mahiyangana.',
                'h1' => 'Hotel Gallery',
                'intro' => 'A look around Mounts Edge Regency in Gurulupotha, Hasalaka 20960 — rooms, celebrations, dining, and the grounds near Mahiyangana.',
                'faq' => [],
            ],
            'contact' => [
                'title' => 'Contact Mounts Edge Regency | Hotel Near Mahiyangana',
                'description' => 'Contact Mounts Edge Regency on Kandy Rd, Gurulupotha near Hasalaka and Mahiyangana for stays, dining, weddings, and general enquiries. Call 055 225 6500.',
                'h1' => 'Contact Mounts Edge Regency',
                'intro' => 'Reach Mounts Edge Regency on Kandy Rd, Gurulupotha, Hasalaka 20960, near Mahiyangana — for stays, dining, weddings, and general enquiries.',
                'faq' => [
                    ['q' => 'What is the fastest way to reach the hotel?', 'a' => 'Call 055 225 6500, message on WhatsApp, or send the enquiry form. For directions, use the map on this page.'],
                    ['q' => 'What payment methods are accepted?', 'a' => 'Common payment methods are accepted, including cash and card. Confirm the details for your stay when you enquire.'],
                ],
            ],
        ];
    }

    /** @return array{title:string,description:string,h1:string,intro:string,faq:array} */
    private static function fallbackPage(): array
    {
        return [
            'title' => 'Mounts Edge Regency | Hotel Near Mahiyangana',
            'description' => self::DEFAULT_DESCRIPTION,
            'h1' => 'Mounts Edge Regency',
            'intro' => self::DEFAULT_DESCRIPTION,
            'faq' => [],
        ];
    }

    /** @param array{title:string,h1:string,faq:array} $page @return array<string, mixed> */
    private static function structuredData(?string $routeName, array $page, Request $request, SiteSetting $settings): array
    {
        $homeUrl = url('/');
        $canonical = $request->url();

        $graph = [
            [
                '@type' => 'WebSite',
                '@id' => $homeUrl.'#website',
                'url' => $homeUrl,
                'name' => 'Mounts Edge Regency',
                'inLanguage' => app()->getLocale(),
            ],
            self::hotelNode($settings, $homeUrl),
            self::contactPointNode($settings),
            [
                '@type' => 'BreadcrumbList',
                '@id' => $canonical.'#breadcrumb',
                'itemListElement' => self::crumbs($routeName, $homeUrl, $canonical, $page),
            ],
        ];

        foreach ($page['faq'] as $item) {
            $graph[] = [
                '@type' => 'Question',
                'name' => $item['q'],
                'acceptedAnswer' => ['@type' => 'Answer', 'text' => $item['a']],
            ];
        }

        // Wrap Questions in FAQPage only when present; keep Hotel/WebSite/Breadcrumb always.
        if (! empty($page['faq'])) {
            $graph[] = [
                '@type' => 'FAQPage',
                '@id' => $canonical.'#faq',
                'mainEntity' => array_values(array_filter($graph, fn ($n) => ($n['@type'] ?? '') === 'Question')),
            ];
        }

        return ['@context' => 'https://schema.org', '@graph' => $graph];
    }

    /** @return array<int, array<string, mixed>> */
    private static function crumbs(?string $routeName, string $homeUrl, string $canonical, array $page): array
    {
        $crumbs = [['@type' => 'ListItem', 'position' => 1, 'name' => 'Home', 'item' => $homeUrl]];
        if ($routeName && $routeName !== 'home') {
            $crumbs[] = ['@type' => 'ListItem', 'position' => 2, 'name' => $page['h1'], 'item' => $canonical];
        }

        return $crumbs;
    }

    /** @return array<string, mixed> */
    private static function hotelNode(SiteSetting $settings, string $homeUrl): array
    {
        return [
            '@type' => 'Hotel',
            '@id' => $homeUrl.'#hotel',
            'name' => 'Mounts Edge Regency',
            'url' => $homeUrl,
            'description' => self::DEFAULT_DESCRIPTION,
            'image' => self::openGraphImageUrl(),
            'telephone' => $settings->phone_link ?: null,
            'email' => $settings->public_email,
            'address' => [
                '@type' => 'PostalAddress',
                // Phase 0: full street + postcode pending management sign-off
                // in docs/BUSINESS-TRUTH.md §1. Do not treat this short
                // locality string as the legal postal address.
                'streetAddress' => $settings->address,
                'addressLocality' => 'Gurulupotha',
                'addressRegion' => 'Badulla',
                'addressCountry' => 'LK',
            ],
            'hasMap' => $settings->map_url,
            'sameAs' => [],
        ];
    }

    /** Phase 3: ContactPoint for reservations (owner-verified 2026-10-02). */
    private static function contactPointNode(SiteSetting $settings): array
    {
        return [
            '@type' => 'ContactPoint',
            '@id' => url('/').'#contact-point',
            'contactType' => 'reservations',
            'telephone' => $settings->phone_link ?: null,
            'email' => $settings->public_email,
            'areaServed' => 'LK',
            'availableLanguage' => ['en', 'si', 'ta'],
        ];
    }

    private static function openGraphImageUrl(): string
    {
        return url('/images/og-image.jpg');
    }
}
