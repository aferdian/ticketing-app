<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Customers\Pages\CustomersHomeController;
use App\Http\Controllers\Customers\Pages\CustomersOrderController;
use App\Http\Controllers\Common\Checkouts\CheckoutsController;

// ========================= Landing Page ===========================
Route::redirect('/customer', '/event', 301)->name('home.customer');
Route::get('/customer/event/{id}/detail', [CustomersHomeController::class, 'eventShow'])->name('events.show');

Route::get('/event', [CustomersHomeController::class, 'index'])->name('home');
Route::get('/event/{slug}', [CustomersHomeController::class, 'eventShow'])->name('events.show.slug');

// ========================= Checkout ===========================
Route::middleware(['auth', 'role:customer,admin,superadmin'])
    ->prefix('customer')
    ->group(function () {

        Route::get('/checkout/{token}', [CustomersHomeController::class, 'showCheckoutForm'])->name('checkout.form');

        Route::get('/order', [CustomersOrderController::class, 'index'])->name('orders.customers');
        Route::get('/order/{id}', [CustomersOrderController::class, 'show'])->name('orders.show');
        Route::post('/order/{id}/payment-proof', [CheckoutsController::class, 'uploadPaymentProof'])->name('payment.proof');
    });
