<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\AdminRoomController;
use App\Http\Controllers\AdminWeddingController;
use App\Http\Controllers\WeddingController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\AdminGalleryController;



Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('rooms', AdminRoomController::class);
});

Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    // Rooms CRUD
    Route::resource('rooms', AdminRoomController::class);

    Route::post('room-types', [AdminRoomController::class, 'roomTypesStore'])->name('room-types.store');
    Route::delete('room-types/{roomType}', [AdminRoomController::class, 'roomTypesDestroy'])->name('room-types.destroy');

    // ==========================================
    // Weddings Management Routes
    // ==========================================
    Route::get('weddings', [AdminWeddingController::class, 'index'])->name('weddings.index');
    
    // Hall CRUD
    Route::post('weddings/hall', [AdminWeddingController::class, 'storeHall'])->name('weddings.hall.store');
    Route::put('weddings/hall/{hall}', [AdminWeddingController::class, 'updateHall'])->name('weddings.hall.update');
    Route::delete('weddings/hall/{hall}', [AdminWeddingController::class, 'destroyHall'])->name('weddings.hall.destroy');
    
    // Packages CRUD
    Route::post('weddings/packages', [AdminWeddingController::class, 'storePackage'])->name('weddings.packages.store');
    Route::put('weddings/packages/{package}', [AdminWeddingController::class, 'updatePackage'])->name('weddings.packages.update');
    Route::delete('weddings/packages/{package}', [AdminWeddingController::class, 'destroyPackage'])->name('weddings.packages.destroy');

    // Catering & Decoration (Single Updates)
    Route::post('weddings/catering', [AdminWeddingController::class, 'updateCatering'])->name('weddings.catering.update');
    Route::post('weddings/decoration', [AdminWeddingController::class, 'updateDecoration'])->name('weddings.decoration.update');

    // Gallery Management Routes
    Route::get('gallery', [AdminGalleryController::class, 'index'])->name('gallery.index');

    Route::post('gallery/categories', [AdminGalleryController::class, 'storeCategory'])->name('gallery.categories.store');
    Route::delete('gallery/categories/{category}', [AdminGalleryController::class, 'destroyCategory'])->name('gallery.categories.destroy');

    Route::post('gallery/items', [AdminGalleryController::class, 'storeItem'])->name('gallery.items.store');
    Route::put('gallery/items/{item}', [AdminGalleryController::class, 'updateItem'])->name('gallery.items.update');
    Route::delete('gallery/items/{item}', [AdminGalleryController::class, 'destroyItem'])->name('gallery.items.destroy');

    });



Route::get('/luxury-stay', [RoomController::class, 'index'])->name('luxury-stay');

Route::get('/weddings', [WeddingController::class, 'index'])->name('weddings');

Route::get('/dining', function () {
    return view('dining');
});

Route::get('/experiences', function () {
    return view('experiences');
});

Route::get('/gallery', [GalleryController::class, 'index'])->name('gallery');

Route::get('/contact', function () {
    return view('contact');
});

require __DIR__.'/auth.php';
