<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\CartController;

use App\Http\Controllers\SearchController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

use App\Models\Product;

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

// Home Page
Route::get('/', function () {
    // Retrieve the latest 10 products from the database
    $products = Product::latest()->take(10)->get();

    // Pass the products to the view
    return view('home', compact('products'));
})->name('home');


// Register
Route::get('/register', function () {
    return view('auth.register');
})->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('auth.register');


// // Email Verification
// Route::get('/email/verify', [EmailVerificationController::class, 'notice'])
//     ->middleware(['auth'])
//     ->name('verification.notice');

// Route::get('/email/verify/{id}/{hash}', [EmailVerificationController::class, 'verify'])
//     ->middleware(['auth', 'signed', 'throttle:6,1'])
//     ->name('verification.verify');

// Route::post('/email/verification-notification', [EmailVerificationController::class, 'resend'])
//     ->middleware(['auth', 'throttle:6,1'])
//     ->name('verification.send');


// Login
Route::get('/login', function () {
    if (auth()->check()) {
        return redirect()->route('home');
    }
    return view('auth.login');
})->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('auth.login');


// Logout
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');


// Users admin
Route::middleware(['admin'])->group(function () {
    Route::get('/users',[UserController::class, 'index'])->name('users.index');
});
// Categories admin
Route::middleware(['admin'])->group(function () {
    Route::get('/categorycreate', [CategoryController::class, 'create'])->name('category.create');
    Route::post('/categorystore', [CategoryController::class, 'store'])->name('category.store');

    Route::get('/category/edit/{id}', [CategoryController::class, 'edit'])->name('category.edit');
    Route::put('/category/update/{id}', [CategoryController::class, 'update'])->name('category.update');

    Route::get('/categories', [CategoryController::class, 'index'])->name('category.index');
    Route::get('/category/{id}', [CategoryController::class, 'show'])->name('category.show');

});

// Products admin
Route::middleware(['admin'])->group(function () {
    Route::get('/products/create',[ProductController::class, 'create'])->name('product.create');
    Route::post('/products/store', [ProductController::class, 'store'])->name('product.store');

    Route::get('/products/edit/{id}', [ProductController::class, 'edit'])->name('product.edit');
    Route::put('/products/update/{id}', [ProductController::class, 'update'])->name('product.update');

    Route::delete('/products/{id}', [ProductController::class, 'destroy'])->name('product.destroy');

});

// Products all
Route::get('/products', [ProductController::class, 'index'])->name('product.index');
Route::get('/products/{id}', [ProductController::class, 'show'])->name('product.show');

// purchasing
Route::post('/product/{product}/buy', [PurchaseController::class, 'buy'])->name('product.buy')->middleware('auth');
Route::get('/orders/{order}/confirmation', [OrderController::class, 'confirmation'])->name('order.confirmation');


// Orders admin
Route::middleware(['admin'])->group(function () {
    Route::get('/all-orders', [OrderController::class, 'allOrders'])->name('orders.all');
});

// Orders normal
Route::get('/orders/history/{user}', [OrderController::class, 'index'])->name('orders.index')->middleware('auth');
Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show')->middleware('auth');
Route::delete('/orders/{order}', [OrderController::class, 'destroy'])->name('orders.destroy')->middleware('auth');


// Searching
Route::get('/search', [SearchController::class, 'search'])->name('search');


// Add to cart
Route::post('/cart/add/{product}', [CartController::class, 'add'])->name('cart.add')->middleware('auth');
Route::get('/cart', [CartController::class, 'index'])->name('cart.index')->middleware('auth');
Route::delete('/cart/{id}', [CartController::class, 'removeItem'])->name('cart.remove')->middleware('auth');
Route::delete('/cart/{id}/remove-one', [CartController::class, 'removeOne'])->name('cart.removeOne')->middleware('auth');
Route::post('/cart/buy', [CartController::class, 'buy'])->name('cart.buy')->middleware('auth');





// Profile
Route::get('/profile/{user}', [ProfileController::class, 'view'])->name('profile.view')->middleware('auth');
Route::put('/profile/update/{user}', [ProfileController::class, 'update'])->name('profile.update')->middleware('auth');
Route::put('/profile/remove-picture/{user}', [ProfileController::class, 'removePic'])->name('profile.removePic')->middleware('auth');
Route::delete('/user/{user}', [UserController::class, 'destroy'])->name('user.destroy');




//php artisan route:list
//php artisan make:migration create_products_table
//php artisan make:model -r -c -s -f
