<?php

namespace App\Http\Controllers;

use App\Models\GalleryItem;
use App\Models\Room;
use App\Models\WeddingCatering;
use App\Models\WeddingDecoration;
use App\Models\WeddingHall;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Schema;

class SitemapController extends Controller
{
    public function robots(): Response
    {
        $content = implode(PHP_EOL, [
            'User-agent: *',
            'Allow: /',
            'Disallow: /admin/',
            'Disallow: /dashboard',
            'Disallow: /login',
            'Disallow: /register',
            'Disallow: /profile',
            'Disallow: /forgot-password',
            'Disallow: /reset-password',
            'Disallow: /verify-email',
            'Disallow: /confirm-password',
            '',
            'Sitemap: '.url('/sitemap.xml'),
        ]).PHP_EOL;

        return response($content, 200, ['Content-Type' => 'text/plain; charset=UTF-8']);
    }

    public function index(): Response
    {
        return response()->view('seo.sitemap-index', [
            'sitemaps' => [
                url('/page-sitemap.xml'),
                url('/image-sitemap.xml'),
            ],
        ], 200, ['Content-Type' => 'application/xml; charset=UTF-8']);
    }

    public function pages(): Response
    {
        return response()->view('seo.page-sitemap', [
            'pages' => [
                route('home'),
                route('luxury-stay'),
                route('weddings'),
                route('dining'),
                route('experiences'),
                route('gallery'),
                route('contact'),
            ],
            // All content on these pages is static markup or copy; a single
            // deploy-level date is accurate and avoids per-row bookkeeping.
            'lastmod' => now()->toDateString(),
        ], 200, ['Content-Type' => 'application/xml; charset=UTF-8']);
    }

    public function images(): Response
    {
        return response()->view('seo.image-sitemap', [
            'images' => $this->imageEntries(),
        ], 200, ['Content-Type' => 'application/xml; charset=UTF-8']);
    }

    /** @return array<int, array{page: string, image: string, title: string, caption?: string}> */
    private function imageEntries(): array
    {
        if (! Schema::hasTable('rooms')) {
            return [];
        }

        // Phase 0 guard: BUSINESS-TRUTH.md §3-4 publish flags not yet signed.
        // Until then only expose gallery images (curated by hotel); room/hall
        // rows may be seeder placeholders. Flip to true after verification.
        $verified = (bool) env('SEO_CONTENT_VERIFIED', false);

        $entries = [];
        if ($verified) {
            $this->appendImages($entries, route('luxury-stay'), Room::query()->get(), 'room');
            $this->appendImages($entries, route('weddings'), WeddingHall::query()->get(), 'wedding venue');
            $this->appendImages($entries, route('weddings'), WeddingCatering::query()->get(), 'wedding catering');
            $this->appendImages($entries, route('weddings'), WeddingDecoration::query()->get(), 'wedding decoration');
        }
        $this->appendImages($entries, route('gallery'), GalleryItem::query()->get(), 'gallery image', includeCaptions: true);

        $deduplicated = [];
        foreach ($entries as $entry) {
            $deduplicated[$entry['page'].'|'.$entry['image']] = $entry;
        }

        return array_values($deduplicated);
    }

    /**
     * @param  array<int, array{page: string, image: string, title: string, caption?: string}>  $entries
     * @param  iterable<int, object>  $records
     */
    private function appendImages(array &$entries, string $pageUrl, iterable $records, string $fallbackLabel, bool $includeCaptions = false): void
    {
        foreach ($records as $record) {
            $name = trim((string) ($record->name ?? $record->description ?? $fallbackLabel));
            $caption = trim((string) ($record->description ?? ''));
            $paths = array_merge(
                [(string) ($record->image ?? '')],
                is_array($record->images ?? null) ? $record->images : []
            );

            foreach (array_unique(array_filter($paths, fn ($path) => is_string($path) && $path !== '')) as $path) {
                $entry = [
                    'page' => $pageUrl,
                    'image' => $this->absoluteImageUrl($path),
                    'title' => $name.' | Mounts Edge Regency',
                ];
                // Gallery rows have no `name`; their `description` is the
                // factual caption and belongs in image:caption as well.
                if ($includeCaptions && $caption !== '') {
                    $entry['caption'] = $caption;
                }

                $entries[] = $entry;
            }
        }
    }

    private function absoluteImageUrl(string $path): string
    {
        return filter_var($path, FILTER_VALIDATE_URL) ? $path : url('/'.ltrim($path, '/'));
    }
}
