<?php

namespace Tests\Feature;

use App\Models\Room;
use App\Models\GalleryCategory;
use App\Models\GalleryItem;
use App\Models\RoomType;
use App\Models\WeddingHall;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SeoFoundationTest extends TestCase
{
    use RefreshDatabase;

    public function test_homepage_has_canonical_metadata_and_hotel_schema(): void
    {
        $this->get('/')
            ->assertOk()
            ->assertSee('<title>Hotel in Mahiyangana, Sri Lanka | Mounts Edge Regency</title>', false)
            ->assertSee('<link rel="canonical" href="http://localhost">', false)
            ->assertSee('name="robots" content="index, follow"', false)
            ->assertSee('"@type":"Hotel"', false)
            ->assertSee('"@type":"BreadcrumbList"', false)
            ->assertSee('"@type":"FAQPage"', false);
    }

    public function test_each_public_page_has_its_own_title(): void
    {
        $this->get('/luxury-stay')
            ->assertOk()
            ->assertSee('<title>Rooms &amp; Accommodation in Mahiyangana | Mounts Edge Regency</title>', false)
            ->assertSee('Rooms &amp; Accommodation Near Mahiyangana', false)
            ->assertSee('"@type":"BreadcrumbList"', false);

        $this->get('/weddings')
            ->assertOk()
            ->assertSee('<title>Wedding Venue in Mahiyangana | Mounts Edge Regency</title>', false)
            ->assertSee('Wedding Venue Near Mahiyangana', false);

        $this->get('/contact')
            ->assertOk()
            ->assertSee('<title>Contact Mounts Edge Regency | Hotel Near Mahiyangana</title>', false)
            ->assertSee('Contact Mounts Edge Regency', false)
            ->assertSee('Check-in: 2:00 PM', false)
            ->assertSee('Check-out: 12:00 PM', false);
    }

    public function test_homepage_hotel_schema_carries_verified_checkin_and_checkout_times(): void
    {
        $this->get('/')
            ->assertOk()
            ->assertSee('"checkinTime":"14:00"', false)
            ->assertSee('"checkoutTime":"12:00"', false);
    }

    public function test_homepage_hotel_schema_links_the_verified_external_profiles(): void
    {
        $response = $this->get('/');

        $response->assertOk();
        $json = $this->extractStructuredData($response->getContent());
        $hotel = collect($json['@graph'])->firstWhere('@type', 'Hotel');

        $this->assertSame(
            [
                'https://www.google.com/travel/hotels/s/v7feK1Y3vjKSCQUd7',
                'https://www.booking.com/Share-bhyTA3',
                'https://www.tripadvisor.com/Hotel_Review-g11913538-d12951993-Reviews-Mounts_Edge_Regency-Gurulupotha_Kandy_District_Central_Province.html',
                'https://www.agoda.com/en-ca/mounts-edge-regency/hotel/galuke-lk.html',
                'https://www.facebook.com/MountsEdgeRegency',
            ],
            $hotel['sameAs']
        );
    }

    public function test_public_pages_use_page_specific_open_graph_images(): void
    {
        $this->get('/')
            ->assertOk()
            ->assertSee('<meta property="og:image" content="http://localhost/images/og/home.jpg">', false);

        $this->get('/luxury-stay')
            ->assertOk()
            ->assertSee('<meta property="og:image" content="http://localhost/images/og/rooms.jpg">', false);

        $this->get('/weddings')
            ->assertOk()
            ->assertSee('<meta property="og:image" content="http://localhost/images/og/weddings.jpg">', false);

        $this->get('/contact')
            ->assertOk()
            ->assertSee('<meta property="og:image" content="http://localhost/images/og/contact.jpg">', false);
    }

    public function test_experiences_page_promotes_hotel_operated_services(): void
    {
        $this->get('/experiences')
            ->assertOk()
            ->assertSee('<title>Tours, Transport &amp; Things to Do Near Mahiyangana | Mounts Edge Regency</title>', false)
            ->assertSee('Tours, Transport &amp; Day-Outs', false)
            ->assertSee('operated by Mounts Edge Regency, not by an outside partner', false)
            ->assertSee('there are no fixed packages', false)
            ->assertSee('"@type":"FAQPage"', false)
            ->assertSee('Plan Your Excursion', false)
            ->assertDontSee('/tours-and-transport', false);

        $this->get('/page-sitemap.xml')
            ->assertOk()
            ->assertSee('<loc>http://localhost/experiences</loc>', false)
            ->assertDontSee('<loc>http://localhost/tours-and-transport</loc>', false);

        $this->get('/experiences')
            ->assertOk()
            ->assertSee('href="http://localhost/contact?type=Service%20Enquiry"', false);

        $this->get('/tours-and-transport')->assertNotFound();
    }

    /**
     * @return array<string, mixed>
     */
    private function extractStructuredData(string $html): array
    {
        preg_match('/<script type="application\/ld\+json">(.*?)<\/script>/s', $html, $matches);

        $this->assertNotEmpty($matches);

        return json_decode($matches[1], true);
    }

    public function test_room_inventory_has_one_canonical_family_suite(): void
    {
        $this->seed(\Database\Seeders\RoomSeeder::class);

        $response = $this->get('/luxury-stay');

        $response->assertOk()
            ->assertSee('Deluxe Single Room', false)
            ->assertSee('Deluxe Double Room', false)
            ->assertSee('Deluxe Triple Room', false)
            ->assertSee('Family Suite', false)
            ->assertSee('8 guests', false)
            ->assertSee('538 ft² · 4 large double beds', false)
            ->assertDontSee('Deluxe Family Room', false);

        $this->assertSame(4, Room::count());
        $this->assertTrue(Room::where('name', 'Family Suite')->exists());
        $this->assertFalse(Room::where('name', 'Deluxe Family Room')->exists());
    }

    public function test_robots_file_blocks_private_routes_and_advertises_the_sitemap(): void
    {
        $this->get('/robots.txt')
            ->assertOk()
            ->assertSee('Disallow: /admin/', false)
            ->assertSee('Disallow: /login', false)
            ->assertSee('Sitemap: http://localhost/sitemap.xml', false);
    }

    public function test_sitemap_index_lists_page_and_image_sitemaps(): void
    {
        $this->get('/sitemap.xml')
            ->assertOk()
            ->assertSee('<loc>http://localhost/page-sitemap.xml</loc>', false)
            ->assertSee('<loc>http://localhost/image-sitemap.xml</loc>', false);

        $this->get('/page-sitemap.xml')
            ->assertOk()
            ->assertSee('<loc>http://localhost/luxury-stay</loc>', false)
            ->assertSee('<loc>http://localhost/contact</loc>', false);
    }

    public function test_image_sitemap_uses_images_managed_by_the_hotel(): void
    {
        // Phase 0 gate: unverified room/hall rows stay out of the sitemap
        // until BUSINESS-TRUTH.md is signed (SEO_CONTENT_VERIFIED=true).
        putenv('SEO_CONTENT_VERIFIED=true');
        $_ENV['SEO_CONTENT_VERIFIED'] = true;
        $_SERVER['SEO_CONTENT_VERIFIED'] = true;
        $roomType = RoomType::create(['name' => 'Test rooms', 'slug' => 'test-rooms', 'icon' => 'home']);
        Room::create([
            'room_type_id' => $roomType->id,
            'name' => 'Garden Room',
            'tagline' => 'Garden comfort',
            'description' => 'A test room used to verify the image sitemap.',
            'image' => '/storage/rooms/garden-room.jpg',
            'images' => ['/storage/rooms/garden-room.jpg'],
            'capacity' => '2 guests',
            'size' => '30 sqm',
        ]);
        WeddingHall::create([
            'name' => 'Garden Hall',
            'tagline' => 'Garden celebrations',
            'description' => 'A test hall used to verify the image sitemap.',
            'image' => '/storage/weddings/garden-hall.jpg',
            'capacity' => '100 guests',
            'area' => '1,000 sq ft',
            'style' => 'Garden',
        ]);
        $category = GalleryCategory::create(['name' => 'Property']);
        GalleryItem::create([
            'gallery_category_id' => $category->id,
            'image' => '/storage/gallery/property.jpg',
            'description' => 'Pool area',
        ]);
        $escapedCategory = GalleryCategory::create(['name' => 'Amenities']);
        GalleryItem::create([
            'gallery_category_id' => $escapedCategory->id,
            'image' => '/storage/gallery/amenities.jpg',
            'description' => 'Bathrooms & views at Mounts Edge Regency',
        ]);

        $this->get('/image-sitemap.xml')
            ->assertOk()
            ->assertSee('<image:loc>http://localhost/storage/rooms/garden-room.jpg</image:loc>', false)
            ->assertSee('<image:loc>http://localhost/storage/weddings/garden-hall.jpg</image:loc>', false)
            ->assertSee('<image:loc>http://localhost/storage/gallery/property.jpg</image:loc>', false)
            ->assertSee('<image:caption>Pool area</image:caption>', false)
            ->assertSee('<image:caption>Bathrooms &amp; views at Mounts Edge Regency</image:caption>', false)
            ->assertDontSee('<image:caption></image:caption>', false);
    }
}
