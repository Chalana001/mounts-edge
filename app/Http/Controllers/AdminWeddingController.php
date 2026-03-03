<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WeddingHall;
use App\Models\WeddingPackage;
use App\Models\WeddingCatering;
use App\Models\WeddingDecoration;
use Illuminate\Support\Facades\Storage;

class AdminWeddingController extends Controller
{
    public function index()
    {
        $hall = WeddingHall::all() ?? new WeddingHall();
        $catering = WeddingCatering::first() ?? new WeddingCatering();
        $decoration = WeddingDecoration::first() ?? new WeddingDecoration();
        $packages = WeddingPackage::all();

        return view('admin.weddings.index', compact('hall', 'catering', 'decoration', 'packages'));
    }

    //WEDDING HALL
    public function storeHall(Request $request)
    {
        $data = $request->except(['image', 'features']);
        if ($request->hasFile('image')) {
            $data['image'] = '/storage/' . $request->file('image')->store('weddings', 'public');
        }
        $data['features'] = array_filter($request->features ?? []);
        WeddingHall::create($data);
        return redirect()->back()->with('success', 'Wedding Hall added successfully!');
    }

    public function updateHall(Request $request, WeddingHall $hall)
    {
        $data = $request->except(['image', 'features']);
        if ($request->hasFile('image')) {
            if ($hall->image) Storage::disk('public')->delete(str_replace('/storage/', '', $hall->image));
            $data['image'] = '/storage/' . $request->file('image')->store('weddings', 'public');
        }
        $data['features'] = array_filter($request->features ?? []);
        $hall->update($data);
        return redirect()->back()->with('success', 'Hall updated successfully!');
    }

    public function destroyHall(WeddingHall $hall)
    {
        if ($hall->image) Storage::disk('public')->delete(str_replace('/storage/', '', $hall->image));
        $hall->delete();
        return redirect()->back()->with('success', 'Hall deleted successfully!');
    }
    //WEDDING PACKAGES (CRUD)
    public function storePackage(Request $request)
    {
        $data = $request->except(['includes']);
        $data['includes'] = array_filter($request->includes ?? []);
        $data['is_popular'] = $request->has('is_popular');
        
        WeddingPackage::create($data);
        return redirect()->back()->with('success', 'Package added successfully!');
    }

    public function updatePackage(Request $request, WeddingPackage $package)
    {
        $data = $request->except(['includes']);
        $data['includes'] = array_filter($request->includes ?? []);
        $data['is_popular'] = $request->has('is_popular');

        $package->update($data);
        return redirect()->back()->with('success', 'Package updated successfully!');
    }

    public function destroyPackage(WeddingPackage $package)
    {
        $package->delete();
        return redirect()->back()->with('success', 'Package deleted successfully!');
    }

    //CATERING & MENU
    public function updateCatering(Request $request)
    {
        $catering = WeddingCatering::first() ?? new WeddingCatering();
        $data = $request->except(['image', 'list_items', 'tags']);

        if ($request->hasFile('image')) {
            if ($catering->image && str_contains($catering->image, '/storage/')) {
                Storage::disk('public')->delete(str_replace('/storage/', '', $catering->image));
            }
            $data['image'] = '/storage/' . $request->file('image')->store('weddings', 'public');
        }

        $data['list_items'] = array_filter($request->list_items ?? []);
        $data['tags'] = array_filter($request->tags ?? []);

        $catering->fill($data)->save();
        return redirect()->back()->with('success', 'Catering details updated successfully!');
    }

    //DECORATIONS
    public function updateDecoration(Request $request)
    {
        $decoration = WeddingDecoration::first() ?? new WeddingDecoration();
        $data = $request->except(['image', 'list_items', 'tags']);

        if ($request->hasFile('image')) {
            if ($decoration->image && str_contains($decoration->image, '/storage/')) {
                Storage::disk('public')->delete(str_replace('/storage/', '', $decoration->image));
            }
            $data['image'] = '/storage/' . $request->file('image')->store('weddings', 'public');
        }

        $data['list_items'] = array_filter($request->list_items ?? []);
        $data['tags'] = array_filter($request->tags ?? []);

        $decoration->fill($data)->save();
        return redirect()->back()->with('success', 'Decoration details updated successfully!');
    }
}