<?php

use App\Livewire\Actions\Logout;
use App\Livewire\Home;
use App\Livewire\Profile\ProfileView;
use App\Livewire\Shop\AllProducts;
use Illuminate\Support\Facades\Route;
use App\Livewire\Shop\ShowCart;
use App\Livewire\Shop\EditPeople;
use App\Livewire\ListLiked;
use Symfony\Component\HttpKernel\Profiler\Profile;
use Termwind\Components\Li;

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

Route::get('/list-like', ListLiked::class)
    ->name('list-like')
    ->middleware('auth');

Route::get('edit/people/{id}', EditPeople::class)
    ->name('people.edit')
    ->middleware('auth')
    ->middleware('permissionToEdit')
    ->whereNumber('id');
    

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
