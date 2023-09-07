<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PurchaseController;

use App\Http\Controllers\SearchController;
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


// Products
Route::middleware(['admin'])->group(function () {
    Route::get('/products/create',[ProductController::class, 'create'])->name('product.create');
    Route::post('/products/store', [ProductController::class, 'store'])->name('product.store');

    Route::get('/products/update/{id}', [ProductController::class, 'update'])->name('product.update');
    Route::put('/products/edit/{id}', [ProductController::class, 'edit'])->name('product.edit');

    Route::delete('/products/{id}', [ProductController::class, 'destroy'])->name('product.destroy');
});
Route::get('/products', [ProductController::class, 'index'])->name('product.index');
Route::get('/products/{id}', [ProductController::class, 'show'])->name('product.show');
// purchasing
Route::post('/product/{product}/buy', [PurchaseController::class, 'buy'])->name('product.buy')->middleware('auth');
Route::get('/orders/{order}/confirmation', [OrderController::class, 'confirmation'])->name('order.confirmation');


// Orders
Route::resource('/orders', OrderController::class)->middleware('auth');


// Searching
Route::get('/search', [SearchController::class, 'search'])->name('search');


// Profile
Route::get('/profile/{id}', [ProfileController::class, 'view'])->middleware('auth')->name('profile.view');

Route::resource('/category',CategoryController::class);
//php artisan route:list
//php artisan make:migration create_products_table
//php artisan make:model -r -c -s -f
