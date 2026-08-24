<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\HandlesImageUploads;
use App\Models\WeddingCatering;
use App\Models\WeddingDecoration;
use App\Models\WeddingHall;
use App\Models\WeddingPackage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminWeddingController extends Controller
{
    use HandlesImageUploads;

    public function index(): View
    {
        return view('admin.weddings.index', [
            'halls' => WeddingHall::latest()->paginate(8, ['*'], 'halls_page')->withQueryString(),
            'catering' => WeddingCatering::first() ?? new WeddingCatering(),
            'decoration' => WeddingDecoration::first() ?? new WeddingDecoration(),
            'packages' => WeddingPackage::latest()->paginate(10, ['*'], 'packages_page')->withQueryString(),
        ]);
    }

    public function storeHall(Request $request): RedirectResponse
    {
        $data = $request->validate($this->hallRules());
        $data['features'] = $this->cleanList($data['features'] ?? []);

        $images = $this->syncImages($request, [], 'weddings');
        $data['images'] = $images;
        $data['image'] = $images[0];

        WeddingHall::create(\Illuminate\Support\Arr::except($data, ['existing_images', 'new_images']));

        return back()->with('success', 'Wedding Hall added successfully!');
    }

    public function updateHall(Request $request, WeddingHall $hall): RedirectResponse
    {
        $data = $request->validate($this->hallRules());
        $data['features'] = $this->cleanList($data['features'] ?? []);

        $images = $this->syncImages($request, $hall->images ?? [], 'weddings');
        $data['images'] = $images;
        $data['image'] = $images[0];

        $hall->update(\Illuminate\Support\Arr::except($data, ['existing_images', 'new_images']));

        return back()->with('success', 'Hall updated successfully!');
    }

    public function destroyHall(WeddingHall $hall): RedirectResponse
    {
        $this->deletePublicImages($hall->images ?: array_filter([$hall->image]));
        $hall->delete();

        return back()->with('success', 'Hall deleted successfully!');
    }

    public function storePackage(Request $request): RedirectResponse
    {
        $data = $request->validate($this->packageRules());
        $data['includes'] = $this->cleanIncludes($data['includes'] ?? []);
        $data['is_popular'] = $request->boolean('is_popular');
        WeddingPackage::create($data);

        return back()->with('success', 'Package added successfully!');
    }

    public function updatePackage(Request $request, WeddingPackage $package): RedirectResponse
    {
        $data = $request->validate($this->packageRules());
        $data['includes'] = $this->cleanIncludes($data['includes'] ?? []);
        $data['is_popular'] = $request->boolean('is_popular');
        $package->update($data);

        return back()->with('success', 'Package updated successfully!');
    }

    public function destroyPackage(WeddingPackage $package): RedirectResponse
    {
        $package->delete();

        return back()->with('success', 'Package deleted successfully!');
    }

    public function updateCatering(Request $request): RedirectResponse
    {
        $this->updateFeatureSection($request, WeddingCatering::first() ?? new WeddingCatering());

        return back()->with('success', 'Catering details updated successfully!');
    }

    public function updateDecoration(Request $request): RedirectResponse
    {
        $this->updateFeatureSection($request, WeddingDecoration::first() ?? new WeddingDecoration());

        return back()->with('success', 'Decoration details updated successfully!');
    }

    private function hallRules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'tagline' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:5000'],
            'capacity' => ['nullable', 'string', 'max:100'],
            'area' => ['nullable', 'string', 'max:100'],
            'style' => ['nullable', 'string', 'max:255'],
            'features' => ['nullable', 'array'],
            'features.*' => ['nullable', 'string', 'max:255'],
        ] + $this->imageRules();
    }

    private function packageRules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'guests' => ['nullable', 'string', 'max:100'],
            'is_popular' => ['nullable', 'boolean'],
            'includes' => ['nullable', 'array'],
            'includes.*.title' => ['required', 'string', 'max:255'],
            'includes.*.rule' => ['nullable', 'string', 'max:255'],
            'includes.*.items' => ['nullable', 'array'],
            'includes.*.items.*' => ['nullable', 'string', 'max:255'],
        ];
    }

    private function updateFeatureSection(Request $request, WeddingCatering|WeddingDecoration $section): void
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'tagline' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:5000'],
            'list_title' => ['nullable', 'string', 'max:255'],
            'list_items' => ['nullable', 'array'],
            'list_items.*' => ['nullable', 'string', 'max:255'],
            'tags' => ['nullable', 'array'],
            'tags.*' => ['nullable', 'string', 'max:255'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
        ]);

        $data['list_items'] = $this->cleanList($data['list_items'] ?? []);
        $data['tags'] = $this->cleanList($data['tags'] ?? []);

        if ($request->hasFile('image')) {
            $this->deletePublicImage($section->image);
            $data['image'] = '/storage/'.$request->file('image')->store('weddings', 'public');
        }

        $section->fill($data)->save();
    }

    private function cleanList(array $values): array
    {
        return array_values(array_filter(array_map('trim', $values), fn ($value) => $value !== ''));
    }

    private function cleanIncludes(array $sections): array
    {
        return array_values(array_filter(array_map(function ($section) {
            return [
                'title' => trim($section['title'] ?? ''),
                'rule' => trim($section['rule'] ?? ''),
                'items' => $this->cleanList($section['items'] ?? []),
            ];
        }, $sections), fn ($section) => $section['title'] !== '' || ! empty($section['items'])));
    }
}
