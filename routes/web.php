<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\AdminRoomController;
use App\Http\Controllers\AdminWeddingController;
use App\Http\Controllers\WeddingController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\AdminGalleryController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\AdminEnquiryController;
use App\Http\Controllers\AdminSiteSettingController;



Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard', [
        'stats' => [
            'newEnquiries' => \App\Models\Enquiry::where('status', \App\Models\Enquiry::STATUS_NEW)->count(),
            'rooms' => \App\Models\Room::count(),
            'roomTypes' => \App\Models\RoomType::count(),
            'weddingPackages' => \App\Models\WeddingPackage::count(),
            'weddingHalls' => \App\Models\WeddingHall::count(),
            'galleryItems' => \App\Models\GalleryItem::count(),
        ],
    ]);
})->middleware(['auth', 'auth.session', 'admin', 'verified'])->name('dashboard');

Route::middleware(['auth', 'auth.session', 'admin'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
});

Route::middleware(['auth', 'auth.session', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('settings', [AdminSiteSettingController::class, 'edit'])->name('settings.edit');
    Route::put('settings', [AdminSiteSettingController::class, 'update'])->name('settings.update');
    Route::get('enquiries/trash', [AdminEnquiryController::class, 'trash'])->name('enquiries.trash');
    Route::delete('enquiries/trash', [AdminEnquiryController::class, 'emptyTrash'])->name('enquiries.trash.empty');
    Route::get('enquiries', [AdminEnquiryController::class, 'index'])->name('enquiries.index');
    Route::get('enquiries/{enquiry}', [AdminEnquiryController::class, 'show'])->name('enquiries.show');
    Route::patch('enquiries/{enquiry}/status', [AdminEnquiryController::class, 'updateStatus'])->name('enquiries.status');
    Route::delete('enquiries/{enquiry}', [AdminEnquiryController::class, 'destroy'])->name('enquiries.destroy');
    Route::post('enquiries/{enquiry}/restore', [AdminEnquiryController::class, 'restore'])->name('enquiries.restore');
    Route::delete('enquiries/{enquiry}/force', [AdminEnquiryController::class, 'forceDestroy'])->name('enquiries.force-destroy');

    Route::get('users', [AdminUserController::class, 'index'])->name('users.index');
    Route::post('users', [AdminUserController::class, 'store'])->name('users.store');
    Route::put('users/{user}/password', [AdminUserController::class, 'updatePassword'])->name('users.password.update');
    Route::delete('users/{user}', [AdminUserController::class, 'destroy'])->name('users.destroy');

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
Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::post('/send-enquiry', [ContactController::class, 'sendEnquiry'])
    ->middleware('throttle:5,1')
    ->name('enquiry.send');

require __DIR__.'/auth.php';
