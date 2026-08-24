<?php

namespace App\Http\Controllers;

use App\Models\GalleryCategory;
use App\Models\GalleryItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminGalleryController extends Controller
{
    public function index()
    {
        $categories = GalleryCategory::withCount('items')->latest()->get();
        $items = GalleryItem::with('category')->latest()->paginate(20, ['*'], 'gallery_page')->withQueryString();

        return view('admin.gallery.index', compact('categories', 'items'));
    }

    public function storeCategory(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:gallery_categories,name',
        ]);

        GalleryCategory::create([
            'name' => $request->name
        ]);

        return redirect()->back()->with('success', 'Category added successfully!');
    }

    public function destroyCategory(GalleryCategory $category)
    {
        // Categories with images must remain intact to preserve their relationships.
        if ($category->items()->count() > 0) {
            return redirect()->back()->with('error', 'Cannot delete! This category contains images.');
        }

        $category->delete();
        return redirect()->back()->with('success', 'Category deleted successfully!');
    }

    public function storeItem(Request $request)
    {
        $request->validate([
            'gallery_category_id' => 'required|exists:gallery_categories,id',
            'image' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
            'description' => 'nullable|string|max:255',
        ]);

        $imagePath = $request->file('image')->store('gallery', 'public');

        GalleryItem::create([
            'gallery_category_id' => $request->gallery_category_id,
            'image' => '/storage/' . $imagePath,
            'description' => $request->description,
        ]);

        return redirect()->back()->with('success', 'Image uploaded successfully!');
    }

    public function updateItem(Request $request, GalleryItem $item)
    {
        $request->validate([
            'gallery_category_id' => 'required|exists:gallery_categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'description' => 'nullable|string|max:255',
        ]);

        $data = [
            'gallery_category_id' => $request->gallery_category_id,
            'description' => $request->description,
        ];

        if ($request->hasFile('image')) {
            if ($item->image && str_contains($item->image, '/storage/')) {
                Storage::disk('public')->delete(str_replace('/storage/', '', $item->image));
            }
            $imagePath = $request->file('image')->store('gallery', 'public');
            $data['image'] = '/storage/' . $imagePath;
        }

        $item->update($data);

        return redirect()->back()->with('success', 'Image updated successfully!');
    }

    public function destroyItem(GalleryItem $item)
    {
        if ($item->image && str_contains($item->image, '/storage/')) {
            Storage::disk('public')->delete(str_replace('/storage/', '', $item->image));
        }

        $item->delete();

        return redirect()->back()->with('success', 'Image deleted successfully!');
    }
}
