<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ListingController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TenantController;
use App\Http\Controllers\AdminController;

// Landing page of the marketplace
Route::get('/', function () {
    // Fetch 3 latest verified listings to show as featured on landing page
    $featuredListings = \App\Models\Listing::where('is_verified', true)->latest()->take(3)->get();
    return view('welcome', compact('featuredListings'));
});

// Listings search and filter page
Route::get('/listings', [ListingController::class, 'index'])->name('listings.index');

// Individual listing details page
Route::get('/listings/{id}', [ListingController::class, 'show'])->name('listings.show');

// Save message from tenant to landlord
Route::post('/listings/{id}/messages', [ListingController::class, 'sendMessage'])->name('listings.messages.store');

// Landlord info page
Route::get('/landlords', function () {
    return view('landlord');
});

// Landlord dashboard portal
Route::get('/landlord/dashboard', [ListingController::class, 'landlordDashboard'])->name('landlord.dashboard');

// Store new property listing (handles actual file uploads)
Route::post('/landlords/listings', [ListingController::class, 'storeListing'])->name('listings.store');

// Delete listing from landlord portal
Route::delete('/landlords/listings/{id}', [ListingController::class, 'deleteListing'])->name('listings.delete');

// Authentication Routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Tenant Dashboard Portal
Route::get('/tenant/dashboard', [TenantController::class, 'dashboard'])->name('tenant.dashboard');

// Favorites list page
Route::get('/favorites', [TenantController::class, 'favoritesList'])->name('favorites.index');

// Toggle Favorite listing (AJAX / Form Post)
Route::post('/listings/{id}/favorite', [ListingController::class, 'toggleFavorite'])->name('listings.favorite');

// Process Simulated MoMo Payment
Route::post('/listings/{id}/pay', [ListingController::class, 'processPayment'])->name('listings.pay');

// Admin Dashboard Portal
Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
Route::post('/admin/listings/{id}/approve', [AdminController::class, 'approveListing'])->name('admin.approve');




