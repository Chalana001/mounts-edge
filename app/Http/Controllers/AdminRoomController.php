<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\RoomType;
use App\Models\Feature;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminRoomController extends Controller
{
    // ඔක්කොම ඩේටා Index එකෙන්ම යවනවා
    public function index()
    {
        $rooms = Room::with(['roomType', 'features'])->latest()->get();
        $roomTypes = RoomType::withCount('rooms')->latest()->get(); 
        
        // Modal එකේ Checkboxes වලට මේක අනිවාර්යයෙන්ම ඕනේ
        $features = Feature::all(); 
        
        return view('admin.rooms.index', compact('rooms', 'roomTypes', 'features'));
    }

    // Modal එකෙන් එන ඩේටා කෙලින්ම සේව් වෙනවා
    public function store(Request $request)
    {
        $request->validate([
            'room_type_id' => 'required',
            'name' => 'required',
            'tagline' => 'required',
            'description' => 'required',
            'capacity' => 'required',
            'size' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $imagePath = $request->file('image')->store('rooms', 'public');

        $room = Room::create([
            'room_type_id' => $request->room_type_id,
            'name' => $request->name,
            'tagline' => $request->tagline,
            'description' => $request->description,
            'capacity' => $request->capacity,
            'size' => $request->size,
            'image' => '/storage/' . $imagePath,
        ]);

        if ($request->has('features')) {
            $room->features()->attach($request->features);
        }

        return redirect()->route('admin.rooms.index')->with('success', 'Room created successfully.');
    }

    // Modal එකෙන් එන ඩේටා කෙලින්ම අප්ඩේට් වෙනවා
    public function update(Request $request, Room $room)
    {
        $request->validate([
            'room_type_id' => 'required',
            'name' => 'required',
            'tagline' => 'required',
            'description' => 'required',
            'capacity' => 'required',
            'size' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = $request->except(['image', 'features']);

        // අලුත් පින්තූරයක් දැම්මොත් පරණ එක මකලා අලුත් එක දානවා
        if ($request->hasFile('image')) {
            if ($room->image && str_contains($room->image, '/storage/')) {
                Storage::disk('public')->delete(str_replace('/storage/', '', $room->image));
            }
            $imagePath = $request->file('image')->store('rooms', 'public');
            $data['image'] = '/storage/' . $imagePath;
        }

        $room->update($data);

        // Features ටික අලුත් කිරීම
        if ($request->has('features')) {
            $room->features()->sync($request->features);
        } else {
            $room->features()->detach();
        }

        return redirect()->route('admin.rooms.index')->with('success', 'Room updated successfully.');
    }

    public function destroy(Room $room)
    {
        if ($room->image && str_contains($room->image, '/storage/')) {
            Storage::disk('public')->delete(str_replace('/storage/', '', $room->image));
        }
        $room->delete();

        return redirect()->route('admin.rooms.index')->with('success', 'Room deleted successfully.');
    }

    // ============
    // ROOM TYPES
    // ============

    public function roomTypesStore(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'slug' => 'required|unique:room_types',
            'icon' => 'required', 
        ]);

        RoomType::create($request->all());
        return redirect()->route('admin.rooms.index')->with('success', 'Room Type added successfully!');
    }

    public function roomTypesDestroy(RoomType $roomType)
    {
        // කාමර පාවිච්චි වෙනවා නම් මකන්න දෙන්නේ නෑ!
        if ($roomType->rooms()->count() > 0) {
            return redirect()->route('admin.rooms.index')->with('error', 'Cannot delete! This Room Type is being used by existing rooms.');
        }

        $roomType->delete();
        return redirect()->route('admin.rooms.index')->with('success', 'Room Type deleted successfully!');
    }
}