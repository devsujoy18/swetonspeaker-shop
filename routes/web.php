<?php

use App\Http\Controllers\AdminNotificationController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\OldOrderController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SiteSettingController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
})->name('home');

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

// 1. Route for only {type}
Route::get('{type}', function ($type) {
    return view('type_category', ['type' => $type]);
})
    ->where('type', 'pro-loudspeaker|home-loudspeaker')
    ->name('type.category');

// 2️. Category page
Route::get('{type}/{categorySlug}', function ($type, $categorySlug = null) {
    return view('category_products', [
        'type' => $type,
        'categorySlug' => $categorySlug,
    ]);
})
    ->where('type', 'pro-loudspeaker|home-loudspeaker')
    ->name('category.products');

// 3️. Product page
Route::get('{type}/{categorySlug}/{productSlug}', function ($type, $categorySlug, $productSlug) {
    return view('product_details', ['type' => $type, 'categorySlug' => $categorySlug, 'productSlug' => $productSlug]);
})
    ->where('type', 'pro-loudspeaker|home-loudspeaker')
    ->name('product.details');

Route::get('/cart', function () {
    return view('cart');
})->name('cart');

Route::get('/checkout', [CheckoutController::class, 'index'])
    ->name('checkout')
    ->middleware(['auth', 'cart.enabled']);

// Guest checkout page
Route::get('/guest-checkout', [CheckoutController::class, 'guestCheckout'])
    ->name('guest.checkout')->middleware('cart.enabled');

Route::post('/place-order', [CheckoutController::class, 'placeOrder'])->name('checkout.place');
Route::get('/payment/{token}', [CheckoutController::class, 'razorpayPaymentPage'])->name('razorpay.payment.page');
Route::post('/razorpay/verify', [CheckoutController::class, 'razorpayVerify'])->name('razorpay.verify');
Route::get('/order/success/{order_number}', [CheckoutController::class, 'success'])->name('checkout.success');
Route::get('/order/failed', [CheckoutController::class, 'failed'])->name('checkout.failed');

/**
 * Razorpay webhook
 **/
Route::post('/razorpay/webhook', [CheckoutController::class, 'handlePayment'])->name('razorpay.webhook');

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::patch('/profile-address', [ProfileController::class, 'update_address'])->name('profile.update.address');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    /**
     * Only for user routes
     */
    Route::get('/my-orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/my-orders/{order_number}', [OrderController::class, 'show'])->name('orders.show');

    // Review routes

    Route::get('old-orders', [OldOrderController::class, 'index'])->name('old.orders');

    Route::prefix('admin')->group(function () {
        // Route::get('/categories', [CategoryController::class, 'manage'])->name('categories.manage');
        Route::get('/categories', function () {
            return view('categories.manage');
        })->name('categories.manage');

        Route::get('/products', function () {
            return view('products.manage');
        })->name('products.manage');

        Route::get('orders', [OrderController::class, 'allOrders'])->name('admin.orders.index');
        Route::patch('/orders/{order}/status', [OrderController::class, 'updateStatus'])->name('admin.orders.updateStatus');
        Route::get('/orders/{order}', [OrderController::class, 'showDetails'])->name('admin.orders.show');
        Route::get('users', [UserController::class, 'index'])->name('admin.users.index');
        Route::get('/users/create', [UserController::class, 'create'])->name('admin.users.create');
        Route::post('/users/store', [UserController::class, 'store'])->name('admin.users.store');
        Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('admin.users.edit');
        Route::put('/users/{user}', [UserController::class, 'update'])->name('admin.users.update');
        Route::post('/users/{user}/change-password', [UserController::class, 'changePassword'])->name('admin.users.change-password');
        Route::post('/users/{user}/toggle-block', [UserController::class, 'toggleBlock'])->name('admin.users.toggle-block');
        Route::get('reports', [ReportController::class, 'index'])->name('admin.reports');
        Route::get('reports/export', [ReportController::class, 'export'])->name('admin.reports.export');
        Route::get('settings', [SiteSettingController::class, 'edit'])->name('admin.settings.edit');
        Route::post('settings', [SiteSettingController::class, 'update'])->name('admin.settings.update');
        Route::get('reports/sucess-order', [ReportController::class, 'success_order'])->name('admin.orders.report.success');
        Route::get('reports/sucess-order/export', [ReportController::class, 'success_order_export'])->name('admin.orders.report.success.export');

        Route::get('/pincode-master', function () {
            return view('settings.pincode_master');
        })->name('admin.pincodemaster');

        Route::get('/tag-master', function () {
            return view('settings.tag_master');
        })->name('admin.tagmaster');

        // Review management
        Route::get('/reviews', function () {
            return view('orders.all_reviews');
        })->name('admin.reviews.index');

        Route::get('/reviews/{reviewId}', [OrderController::class, 'review_details'])->name('admin.reviews.show');

        // Modify existing order
        Route::get('/modify-order/{order}', [OrderController::class, 'modifyOrder'])->name('admin.orders.modify');

        // Notification routes
        Route::get('/notifications', [AdminNotificationController::class, 'index'])->name('admin.notifications.index');
        Route::post('/notifications/{notification}/mark-as-read', [AdminNotificationController::class, 'markAsRead'])->name('admin.notifications.mark-as-read');
        Route::post('/notifications/mark-all-read', [AdminNotificationController::class, 'markAllAsRead'])->name('admin.notifications.mark-all-read');
        Route::delete('/notifications/{notification}', [AdminNotificationController::class, 'destroy'])->name('admin.notifications.destroy');

    });

    // Review routes
    // Route::get('/reviews/create/{order_number}', \App\Livewire\Reviews\ReviewComponent::class)->name('reviews.create');
    Route::get('reviews/create/{order_number}', [OrderController::class, 'product_review'])->name('reviews.create');
});

require __DIR__.'/auth.php';
