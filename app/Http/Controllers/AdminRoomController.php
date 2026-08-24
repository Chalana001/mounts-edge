<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\HandlesImageUploads;
use App\Models\Room;
use App\Models\RoomType;
use App\Models\Feature;
use Illuminate\Http\Request;

class AdminRoomController extends Controller
{
    use HandlesImageUploads;

    public function index()
    {
        $rooms = Room::with(['roomType', 'features'])->latest()->paginate(12, ['*'], 'rooms_page')->withQueryString();
        $roomTypes = RoomType::withCount('rooms')->latest()->get(); 
        
        // The modal needs the full feature list for its checkboxes.
        $features = Feature::all(); 
        
        return view('admin.rooms.index', compact('rooms', 'roomTypes', 'features'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'room_type_id' => 'required|integer|exists:room_types,id',
            'name' => 'required|string|max:255',
            'tagline' => 'required|string|max:255',
            'description' => 'required|string|max:5000',
            'capacity' => 'required|string|max:100',
            'size' => 'required|string|max:100',
            'features' => 'nullable|array',
            'features.*' => 'integer|exists:features,id',
        ] + $this->imageRules());

        $images = $this->syncImages($request, [], 'rooms');

        $room = Room::create([
            'room_type_id' => $request->room_type_id,
            'name' => $request->name,
            'tagline' => $request->tagline,
            'description' => $request->description,
            'capacity' => $request->capacity,
            'size' => $request->size,
            'images' => $images,
            'image' => $images[0],
        ]);

        if ($request->has('features')) {
            $room->features()->attach($request->features);
        }

        return redirect()->route('admin.rooms.index')->with('success', 'Room created successfully.');
    }

    public function update(Request $request, Room $room)
    {
        $validated = $request->validate([
            'room_type_id' => 'required|integer|exists:room_types,id',
            'name' => 'required|string|max:255',
            'tagline' => 'required|string|max:255',
            'description' => 'required|string|max:5000',
            'capacity' => 'required|string|max:100',
            'size' => 'required|string|max:100',
            'features' => 'nullable|array',
            'features.*' => 'integer|exists:features,id',
        ] + $this->imageRules());

        $data = \Illuminate\Support\Arr::except($validated, ['existing_images', 'new_images', 'features']);

        $images = $this->syncImages($request, $room->images ?? [], 'rooms');
        $data['images'] = $images;
        $data['image'] = $images[0];

        $room->update($data);

        if ($request->has('features')) {
            $room->features()->sync($request->features);
        } else {
            $room->features()->detach();
        }

        return redirect()->route('admin.rooms.index')->with('success', 'Room updated successfully.');
    }

    public function destroy(Room $room)
    {
        $this->deletePublicImages($room->images ?: array_filter([$room->image]));
        $room->delete();

        return redirect()->route('admin.rooms.index')->with('success', 'Room deleted successfully.');
    }

    public function roomTypesStore(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|alpha_dash|unique:room_types',
            'icon' => 'required|string|max:5000',
        ]);

        RoomType::create($request->only(['name', 'slug', 'icon']));
        return redirect()->route('admin.rooms.index')->with('success', 'Room Type added successfully!');
    }

    public function roomTypesDestroy(RoomType $roomType)
    {
        // Keep room types that are still assigned to rooms.
        if ($roomType->rooms()->count() > 0) {
            return redirect()->route('admin.rooms.index')->with('error', 'Cannot delete! This Room Type is being used by existing rooms.');
        }

        $roomType->delete();
        return redirect()->route('admin.rooms.index')->with('success', 'Room Type deleted successfully!');
    }
}
