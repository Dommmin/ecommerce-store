<?php

use App\Http\Controllers\Admin;
use App\Http\Controllers\CartController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\ProductController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//Route::get('/', function () {
//    return Inertia::render('Welcome', [
//        'canLogin' => Route::has('login'),
//        'canRegister' => Route::has('register'),
//        'laravelVersion' => Application::VERSION,
//        'phpVersion' => PHP_VERSION,
//    ]);
//});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');
    Route::post('/addFavorite/{variant:id}', [ProductController::class, 'addFavorite'])->name('product.add-to-favorite');
    Route::post('/removeFavorite/{variant:id}', [ProductController::class, 'removeFavorite'])->name('product.remove-from-favorite');
    Route::get('/saved-products', [ProductController::class, 'showMyFavorites'])->name('saved-products');
});

Route::group(['prefix' => 'admin', 'as' => 'admin.'], function () {
    Route::get('/', [Admin\IndexController::class, 'index'])->name('index');
    Route::resource('/product', Admin\ProductController::class);
    Route::resource('/category', Admin\CategoryController::class);
    Route::resource('/brand', Admin\BrandController::class);
    Route::resource('/product/{product}/variant', Admin\ProductVariantController::class);
    Route::resource('/product/{product}/variant/{variant}/option', Admin\ProductOptionController::class);

    Route::post('upload-product-images', [Admin\ProductController::class, 'upload'])->name('product.images.upload');
    Route::post('/upload-product-images-revert', [Admin\ProductController::class, 'uploadRevert'])->name('product.images.revert');

    Route::post('/upload-product-main-image-revert', [Admin\ProductController::class, 'uploadMainImageRevert'])->name('product.main-image.revert');
});

Route::middleware(['guestOrVerified'])->group(function () {
    Route::get('/', [IndexController::class, 'index'])->name('index');

    Route::prefix('/cart')->name('cart.')->group(function () {
        Route::get('/', [CartController::class, 'index'])->name('index');
        Route::post('/add/{option:id}', [CartController::class, 'add'])->name('add');
        Route::post('/remove/{option:id}', [CartController::class, 'remove'])->name('remove');
        Route::post('/updated-quantity/{option:id}', [CartController::class, 'updateQuantity'])->name('update-quantity');
    });
});

Route::resource('/product', ProductController::class)->except('show');
Route::get('/product/{url}', [ProductController::class, 'show'])->name('product.show');
