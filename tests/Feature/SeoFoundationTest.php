<?php

namespace Tests\Feature;

use App\Models\GalleryCategory;
use App\Models\GalleryItem;
use App\Models\Room;
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
            ->assertSee('Contact Mounts Edge Regency', false);
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

        $this->get('/image-sitemap.xml')
            ->assertOk()
            ->assertSee('<image:loc>http://localhost/storage/rooms/garden-room.jpg</image:loc>', false)
            ->assertSee('<image:loc>http://localhost/storage/weddings/garden-hall.jpg</image:loc>', false)
            ->assertSee('<image:loc>http://localhost/storage/gallery/property.jpg</image:loc>', false);
    }
}
