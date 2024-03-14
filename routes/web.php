<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\ServiceController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\UserAddressController;

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

Route::get('/', HomeController::class)->name('home');

Route::middleware('auth')->group(function () {
    Route::prefix('/profile')->controller(ProfileController::class)->name('profile.')->group(function () {
        Route::get('/', 'edit')->name('edit');
        Route::patch('/', 'update')->name('update');
        Route::delete('/', 'destroy')->name('destroy');
    });
    Route::resource('stores', StoreController::class)->except('show');
    Route::get('stores/{store:slug}', [StoreController::class, 'show'])->name('stores.show')->withoutMiddleware('auth');
    Route::resource('stores.products', ProductController::class)->except('store', 'update', 'show');
    Route::resource('stores.services', ServiceController::class)->except('show');
    Route::patch('addresses/{address}/change-current', [UserAddressController::class, 'changeCurrent'])->name('addresses.change-current');
    Route::resource('addresses', UserAddressController::class);
});

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');


require __DIR__ . '/auth.php';
