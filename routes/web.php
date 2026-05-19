<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\EnquiryController;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\AdminPropertyController;
use App\Http\Controllers\Admin\AdminEnquiryController;
use App\Http\Controllers\Admin\AiController;

// Setup Helper
Route::get('/run-setup', function () {
    try {
        Artisan::call('migrate:fresh', ['--seed' => true, '--force' => true]);
        return 'Database migrated and seeded! You can now visit the homepage.';
    } catch (\Exception $e) {
        return 'Error: ' . $e->getMessage();
    }
});

// Public Routes
Route::get('/', [PropertyController::class, 'index'])->name('home');
Route::get('/property/{property}', [PropertyController::class, 'show'])->name('properties.show');
Route::post('/property/{property}/enquire', [EnquiryController::class, 'store'])->name('enquiries.store');

// Admin Auth Routes
Route::get('/admin/login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/login', [AdminAuthController::class, 'login'])->name('admin.login.submit');
Route::post('/admin/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

// Admin Protected Routes
Route::middleware(['auth:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminAuthController::class, 'dashboard'])->name('dashboard');
    
    // Properties CRUD
    Route::resource('properties', AdminPropertyController::class)->except(['create', 'edit']);
    
    // Enquiries List
    Route::get('enquiries', [AdminEnquiryController::class, 'index'])->name('enquiries.index');
    
    // AI API Integration Endpoint
    Route::post('ai/generate-description', [AiController::class, 'generateDescription'])->name('ai.generate-description');
});
