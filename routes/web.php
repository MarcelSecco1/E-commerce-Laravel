<?php

use App\Livewire\Actions\Logout;
use App\Livewire\Home;
use App\Livewire\Profile\ProfileView;
use App\Livewire\Shop\AllProducts;
use Illuminate\Support\Facades\Route;
use App\Livewire\Shop\ShowCart;
use Symfony\Component\HttpKernel\Profiler\Profile;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::view('/', 'welcome')->name('home');
Route::get('/', Home::class)->name('home');
Route::get('/logout', Logout::class)->name('logout');
Route::get('/shop', AllProducts::class)->name('shop.all-products');
Route::get('/cart', ShowCart::class)->name('shop.cart');

// Route::view('dashboard', 'dashboard')
//     ->middleware(['auth', 'verified', 'admin'])
//     ->name('dashboard');

// Route::view('profile', 'profile')
//     ->middleware(['auth'])
//     ->name('profile');

Route::get('/profile', ProfileView::class)
    ->middleware(['auth'])
    ->name('profile');

require __DIR__ . '/auth.php';
