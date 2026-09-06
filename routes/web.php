<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PricingController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\UniqueKeyController;
use App\Http\Controllers\BillingController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\StripeWebhookController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\PlanController;

use App\Models\Post;

// Welcome route
Route::get('/', function () {
    return view('welcome');
});

// Dashboard routes
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


// Pricing routes
Route::middleware(['auth'])->group(function () {

    // Pricing Page
    Route::get('/pricing', [PricingController::class, 'index'])
        ->name('pricing');

    // Activate Free Plan
    Route::post('/plans/{plan}/free', [PricingController::class, 'activateFreePlan'])
        ->name('plans.free');
});

// Unique Key routes
Route::middleware(['auth', 'verified'])->group(function () {

    // Unique Key Page
    Route::get('/unique-key', [UniqueKeyController::class, 'index'])
        ->name('unique-key');

    // Regenerate Unique Key
    Route::post('/unique-key/regenerate', [UniqueKeyController::class, 'regenerate'])
        ->middleware(['auth', 'verified'])
        ->name('unique-key.regenerate');

});

Route::middleware(['auth', 'verified'])->group(function () {

    // Cancel Subscription
    Route::post('/subscription/cancel', [SubscriptionController::class, 'cancel'])
        ->name('subscription.cancel');

});

// Billing routes
Route::middleware(['auth', 'verified'])->group(function () {

    // Billing Page
    Route::get('/billing', [BillingController::class, 'index'])
        ->name('billing');

    // Download Invoice
    Route::get('/billing/invoice/{invoice}', [BillingController::class, 'download'])
        ->middleware(['auth', 'verified'])
        ->name('billing.download');

});

// Checkout routes
Route::middleware('auth')->group(function () {

    // Checkout
    Route::post('/checkout/{plan}', [CheckoutController::class, 'checkout'])
        ->name('checkout');

    // Checkout Success
    Route::get('/checkout/success', [CheckoutController::class, 'success'])
        ->name('checkout.success');

    // Checkout Cancel
    Route::get('/checkout/cancel', [CheckoutController::class, 'cancel'])
        ->name('checkout.cancel');
});

// Admin routes
Route::middleware(['auth', 'role:Admin'])->group(function () {
    // Admin Dashboard
    Route::get('/admin', [AdminController::class, 'index'])
        ->name('admin');
    // Users
    Route::get('/users', [AdminController::class, 'users'])
        ->name('view-all-users');

    // Subscribers
    Route::get('/subscribers', [AdminController::class, 'subscribers'])
        ->name('subscriber-list');

    // Cancelling Subscribers
    Route::get('/cancelling-subscribers', [AdminController::class, 'cancellingSubscribers'])
        ->middleware(['auth', 'role:Admin'])
        ->name('cancelling-subscriber-list');

    // Create Privacy
    Route::get('/create-privacy', function () {
        return view('admin.create-privacy');
    })->name('create-privacy');
    
    // Create Terms
    Route::get('/create-terms', function () {
        return view('admin.create-terms');
    })->name('create-terms');

    Route::get('/admin/legal/{slug}', function (string $slug) {
        return view('admin.legal.editor', compact('slug'));
    })->name('legal.editor');

    // Create Post
    Route::get('/create-post', function () {
        return view('admin.create-post');
    })->name('add-new-post');
    
    // Edit Post
    Route::get('/edit-post/{post}', function (Post $post) {
        return view('admin.edit-post', compact('post'));
    })->name('edit-post');

    // Pages
    Route::get('/admin/pages/{slug}', function (string $slug) {
        return view('admin.pages.editor', compact('slug'));
    })->name('pages.editor');


    // Edit Plans
    Route::get('/admin/plans/{plan}/edit', [PlanController::class, 'edit'])
        ->name('plans.edit');
        
    // Update Plans
    Route::put('/plans/{plan}', [PlanController::class, 'update'])
        ->name('plans.update');
});

// Invoice routes
Route::middleware(['auth', 'role:Admin|Accountant'])->group(function () {
    // Invoice List
    Route::get('/invoice-list', [AdminController::class, 'invoiceList'])
    ->name('invoice-list');

    // Show User Invoices
    Route::get('/admin/invoices/{user}', [AdminController::class, 'showInvoices'])
    ->name('invoice.show');

    // Download Invoice
    Route::get('/admin/invoices/{user}/{invoice}/download', [AdminController::class, 'downloadInvoice'])
    ->name('invoice.download');

});

// Profile routes
Route::middleware('auth')->group(function () {
    // Edit Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

// Privacy Policy
Route::get('/privacy-policy', function () {
    $page = \App\Models\Page::where('slug', 'privacy-policy')
        ->where('is_published', true)
        ->latest()
        ->firstOrFail();

    return view('privacy-policy', compact('page'));
})->name('privacy-policy');

// Terms and Conditions
Route::get('/terms-and-conditions', function () {

    $page = \App\Models\Page::where('slug', 'terms-and-conditions')
        ->where('is_published', true)
        ->first();

    if (! $page) {
        abort(404, 'Terms and Conditions page not found.');
    }

    return view('terms-and-conditions', compact('page'));
})->name('terms-and-conditions');

// Refund Policy
Route::get('/refund-policy', function () {
    $page = \App\Models\Page::where('slug', 'refund-policy')
        ->where('is_published', true)
        ->firstOrFail();

    return view('refund-policy', compact('page'));
})->name('refund-policy');

// Blog Routes
Route::get('/posts', function () {
    $posts = Post::all();
    return view('posts', compact('posts'));
})->name('posts');

// Blog Post Routes
Route::get('/post/{post}', function (Post $post) {
    return view('post', compact('post'));
})->name('post');


// Stripe Webhook
Route::post('/stripe/webhook', [StripeWebhookController::class, 'handleWebhook'])
    ->withoutMiddleware([
        \Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class,
    ]);

require __DIR__.'/api.php';
require __DIR__.'/mobile.php';

