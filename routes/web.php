<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\ShopController;
use App\Http\Controllers\Frontend\CategoryController;
use App\Http\Controllers\Frontend\BrandController;
use App\Http\Controllers\Frontend\ProductController;
use App\Http\Controllers\Frontend\SpecialOfferController;
use App\Http\Controllers\Frontend\BlogController;
use App\Http\Controllers\Frontend\ContactController;
use App\Http\Controllers\Frontend\CustomerAuthController;
use App\Http\Controllers\Frontend\WishlistController;
use App\Http\Controllers\Frontend\CartController;
use App\Http\Controllers\Frontend\PageController;
use App\Http\Controllers\Frontend\FaqController;
use App\Http\Controllers\Frontend\OrderController;
use App\Http\Controllers\Frontend\TrackOrderController;

// Homepage
Route::get('/', [HomeController::class, 'index'])
    ->name('home');

// Shop
Route::get('/shop', [ShopController::class, 'index'])
    ->name('shop');

// Categories
Route::get('/categories', [CategoryController::class, 'index'])
    ->name('categories.index');

Route::get('/category/{slug}', [CategoryController::class, 'show'])
    ->name('categories.show');


Route::get('/brands', [BrandController::class, 'index'])
    ->name('brands.index');

Route::get('/brand/{slug}', [BrandController::class, 'show'])
    ->name('brands.show');


Route::get('/product/{slug}', [ProductController::class, 'show'])
    ->name('product.show');


Route::get('/offers', [SpecialOfferController::class, 'index'])
    ->name('offers.index');


Route::get('/blogs', [BlogController::class, 'index'])
    ->name('blogs.index');

Route::get('/blog/{slug}', [BlogController::class, 'show'])
    ->name('blogs.show');

Route::get('/contact', [ContactController::class, 'index'])
    ->name('contact.index');

Route::post('/contact', [ContactController::class, 'store'])
    ->name('contact.store');

/*
|--------------------------------------------------------------------------
| Customer Account Routes
|--------------------------------------------------------------------------
*/

// Login & Registration Pages
Route::get('/account/login', [CustomerAuthController::class, 'showLogin'])
    ->name('account.login');

Route::get('/account/register', [CustomerAuthController::class, 'showRegister'])
    ->name('account.register');

// Customer Registration
Route::post('/account/register', [CustomerAuthController::class, 'register'])
    ->name('account.register.store');

// Customer Login
Route::post('/account/login', [CustomerAuthController::class, 'login'])
    ->name('account.login.store');

// Customer Dashboard
Route::get('/account', [CustomerAuthController::class, 'index'])
    ->middleware('auth:customer')
    ->name('account.index');

// Customer Logout
Route::post('/account/logout', [CustomerAuthController::class, 'logout'])
    ->middleware('auth:customer')
    ->name('account.logout');

Route::get('/login', function () {
    return redirect()->route('account.login');
})->name('login');

// Customer Wishlist Routes
Route::middleware('auth:customer')->group(function () {

    Route::get('/wishlist', [WishlistController::class, 'index'])
        ->name('wishlist.index');

    Route::post('/wishlist', [WishlistController::class, 'store'])
        ->name('wishlist.store');

    Route::delete('/wishlist/{id}', [WishlistController::class, 'destroy'])
        ->name('wishlist.destroy');

});

// Customer Cart Routes
Route::middleware('auth:customer')->group(function () {

    Route::get('/cart', [CartController::class, 'index'])
        ->name('cart.index');

    Route::post('/cart', [CartController::class, 'store'])
        ->name('cart.store');

    Route::put('/cart/{id}', [CartController::class, 'update'])
        ->name('cart.update');

    Route::delete('/cart/{id}', [CartController::class, 'destroy'])
        ->name('cart.destroy');

    Route::delete('/cart-clear', [CartController::class, 'clear'])
        ->name('cart.clear');

});

// About Us Page
Route::get('/about-us', [PageController::class, 'about'])
    ->name('about');

// FAQ Pages
Route::get('/faq', [FaqController::class, 'index'])
    ->name('faq.index');

Route::post('/faq/{faq}/helpful', [FaqController::class, 'helpful'])
    ->name('faq.helpful');

// Customer Orders
Route::middleware('auth:customer')->group(function () {

    Route::get('/orders', [OrderController::class, 'index'])
        ->name('orders.index');

    Route::get('/orders/{id}', [OrderController::class, 'show'])
        ->name('orders.show');

});

// Track Order Routes
Route::get('/track-order', [TrackOrderController::class, 'index'])
    ->name('track-order.index');

Route::post('/track-order', [TrackOrderController::class, 'track'])
    ->name('track-order.track');
