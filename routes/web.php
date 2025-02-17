<?php

use Illuminate\Support\Facades\Route;
use App\Http\Livewire\Counter;
use App\Http\Livewire\ProductList;

use App\Livewire\Admin\Dashboard as AdminDashboard;
use App\Livewire\User\Dashboard as UserDashboard;
use App\Livewire\Admin\Products;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application.
| These routes are loaded by the RouteServiceProvider and all of them
| will be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// Route group with authentication middleware
Route::middleware([
    'auth:sanctum', 
    config('jetstream.auth_session'), 
    'verified'
])->group(function () {
    
    // Dashboard Route - Redirect based on user role
    Route::get('/dashboard', function () {
        return auth()->user()->isAdmin() 
            ? redirect()->route('admin.dashboard') 
            : redirect()->route('user.dashboard');
    })->name('dashboard'); // Ensure the name for the route

    // User Dashboard Route
    Route::get('/user/dashboard', UserDashboard::class)->name('user.dashboard');

    // Admin Dashboard Route - Only for Admins
    Route::middleware(['admin'])->group(function () {
        Route::get('/admin/dashboard', AdminDashboard::class)->name('admin.dashboard');
    });
});

Route::middleware(['auth:sanctum', 'verified', 'admin'])->group(function () {
    Route::get('/admin/products', Products::class)->name('admin.products');
});