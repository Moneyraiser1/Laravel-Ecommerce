<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Verified;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Category;
use App\Http\Controllers\Setting;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\HomeController;
use App\Models\User;
use App\Http\Controllers\ReportController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// --------------------------------------------------
// Default & Authentication Routes
// --------------------------------------------------
Route::redirect('/', 'user/home');
Route::redirect('/login', 'auth');


Route::get('/auth', fn() => view('auth.authentication'))->name('auth');

// AuthController Routes
Route::controller(AuthController::class)->group(function () {
    Route::post('register', 'register')->name('register');
    Route::post('login', 'login')->name('login');
    Route::post('logout', 'logout')->name('logout');
// Show single user via AJAX (new)
Route::get('/admin/user/{id}',  'showUser')->name('admin.user.show');
Route::delete('/admin/user/{id}', 'destroy')->name('admin.user.delete');
});


Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('admin.home');

// --------------------------------------------------
// Category Routes (Admin)
// --------------------------------------------------
Route::controller(Category::class)->prefix('admin')->group(function () {
    Route::get('/category', 'getAllCategories')->name('admin.category');
    Route::post('/category/add', 'addCat')->name('addCat');
    Route::post('/category/edit', 'editCat')->name('editCat');
    Route::delete('/category/delete/{id}', 'delete')->name('deleteCat');
});
Route::controller(ReportController::class)->prefix('admin')->group(function () {
    Route::get('/report', 'index')->name('admin.report'); 
    Route::get('/report/{id}', 'show')->name('admin.report.show'); 
});


// --------------------------------------------------
// Product Routes (Admin)
// --------------------------------------------------
Route::controller(ProductController::class)->prefix('admin')->group(function () {
    Route::get('/product', 'index')->name('admin.product');               // Product list & form
    Route::get('/product/{id}', 'show')->name('admin.product.show');       // Fetch single product
    Route::post('/product', 'store')->name('admin.product.store');         // Save new product
    Route::get('/product/{id}/edit', 'edit')->name('admin.product.edit');  // Edit product
    Route::put('/product/{id}', 'update')->name('admin.product.update');   // Update product
    Route::delete('/product/{id}', 'destroy')->name('admin.product.delete');// Delete product
});
Route::controller(ProductController::class)->prefix('user')->group(function () {
    Route::get('/product', 'userindex')->name('user.product');               // Product list & form
    Route::get('/product/{id}', 'showuser')->name('product.details');       // Fetch single product
    Route::get('/product/category/{id}', [App\Http\Controllers\ProductController::class, 'category'])->name('shop.category');

});

// --------------------------------------------------
// Admin Pages (Authenticated & Verified)
// --------------------------------------------------
Route::prefix('admin')->middleware(['auth', 'verified'])->group(function () {
    Route::view('/user-management', 'admin.user-management')->name('admin.user-management');

    Route::get('/settings', [Setting::class, 'edit'])->name('admin.settings');
    Route::post('/settings/update', [Setting::class, 'update'])->name('admin.settings.update');
    Route::post('/settings/toggle-dark-mode', [Setting::class, 'toggleDarkMode'])->name('admin.settings.darkmode');
    Route::prefix('admin')->group(function () {
    Route::get('/user-management', [AuthController::class, 'showUserProfile'])
        ->name('admin.showUserProfile');
});

});

use App\Http\Controllers\ProfileController;

Route::middleware(['auth'])->group(function () {
    // Profile page
    Route::get('/user/profile', [ProfileController::class, 'index'])->name('user.profile');
    Route::post('/user/profile/update', [ProfileController::class, 'updateDetails'])->name('user.profile.update'); // NEW
    // Update password
    Route::post('/user/profile/password', [ProfileController::class, 'updatePassword'])->name('user.profile.password');
});


// --------------------------------------------------
// Email Verification Routes
// --------------------------------------------------
Route::get('/email/verify', fn() => view('auth.verify-email'))
    ->middleware('auth')
    ->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function ($id, $hash, Request $request) {
    $user = User::findOrFail($id);

    if ($user->hasVerifiedEmail()) {
        return redirect()->route('auth')->with('message', 'Your email is already verified. Please log in.');
    }

    if (!hash_equals((string) $hash, sha1($user->getEmailForVerification()))) {
        abort(403, 'Invalid verification link.');
    }

    $user->markEmailAsVerified();
    event(new Verified($user));

    return redirect()->route('auth')->with('message', 'Email verified successfully! Please log in.');
})->name('verification.verify');

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return back()->with('message', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');

// --------------------------------------------------
// Authenticated & Verified User Routes
// --------------------------------------------------

    Route::get('/user/home', [HomeController::class, 'index'])->name('user.home');

use App\Http\Controllers\CartController;

Route::middleware(['auth'])->group(function () {
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add/{product}', [CartController::class, 'add'])->name('cart.add');
    Route::post('/cart/update/{id}', [CartController::class, 'update'])->name('cart.update');
    Route::post('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
});

use App\Http\Controllers\CheckoutController;

Route::middleware(['auth'])->group(function () {
   Route::get('/user/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
    Route::get('/checkout/success/{reference}', [CheckoutController::class, 'success'])->name('checkout.success');
});
Route::get('/checkout/callback', [CheckoutController::class, 'callback'])->name('checkout.callback');
