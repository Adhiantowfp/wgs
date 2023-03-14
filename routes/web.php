<?php

use App\Http\Controllers\Admin\adminIndexController;
use App\Http\Controllers\Admin\Auth\adminAuthController;
use App\Http\Controllers\Admin\Store\DataItemsController;
use App\Http\Controllers\Admin\Store\MakeCategoryController;
use App\Http\Controllers\Admin\Store\MakeItemsController;
use App\Http\Controllers\Admin\Store\PaymentItemsController;
use App\Http\Controllers\Admin\User\UserCheckoutController;
use App\Http\Controllers\Admin\User\UserDataController;
use App\Http\Controllers\Store\Auth\storeAuthController;
use App\Http\Controllers\Store\storeAddressController;
use App\Http\Controllers\Store\storeCartController;
use App\Http\Controllers\Store\storeCategoryController;
use App\Http\Controllers\Store\storeCheckOutController;
use App\Http\Controllers\Store\storeIndexController;
use App\Http\Controllers\Store\storeItemController;
use App\Http\Controllers\Store\storePaymentController;
use App\Http\Controllers\Store\storeProductController;
use App\Http\Controllers\Store\storeProfileController;
use Illuminate\Support\Facades\Route;

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


Route::group(['user'], function () {
    Route::post('/user/login', [storeAuthController::class, 'login'])->name('store.login');
    Route::post('/user/register', [storeAuthController::class, 'register'])->name('store.register');
    Route::post('/user/logout', [storeAuthController::class, 'logout'])->name('store.logout');

    Route::get('/', [storeIndexController::class, 'index'])->name('store.index');
    Route::get('/view/product_name={p_name}', [storeProductController::class, 'productView'])->name('store.product.view');
    Route::patch('/add-cart', [storeCartController::class, 'addCart'])->name('store.add.cart');
    Route::patch('/add-cart/item', [storeCartController::class, 'addCartItem'])->name('store.add.cart-item');

    Route::get('/store', [storeItemController::class, 'index'])->name('store.all-product');
    Route::get('/category/{value}', [storeCategoryController::class, 'index'])->name('store.product-category');

    Route::group(['middleware' => 'auth'], function () {
        Route::get('/profile', [storeProfileController::class, 'index'])->name('store.profile');
        Route::patch('/profile', [storeProfileController::class, 'update'])->name('store.profile.update');

        Route::get('/payment-detail/{payment_id}', [storePaymentController::class, 'paymentDetail'])->name('store.payment-detail');
        Route::post('/payment/proof', [storePaymentController::class, 'paymentProof'])->name('store.payment-proof');
        Route::patch('/payment/delete/{payment_id}', [storePaymentController::class, 'paymentDelete'])->name('store.payment-delete');

        Route::post('/add/address', [storeAddressController::class, 'store'])->name('store.add.address');
        Route::patch('/delete/address/{id}', [storeAddressController::class, 'destroy'])->name('store.delete.address');

        Route::get('/checkout', [storeCheckOutController::class, 'index'])->name('store.product-checkout');
        Route::post('/checkout', [storeCheckOutController::class, 'store'])->name('store.product-checkout.submit');
    });
});


Route::group(['admin'], function () {
    Route::group(['middleware' => 'adminLogin'], function () {
        Route::get('/admin/login', [adminAuthController::class, 'login'])->name('admin.login');
        Route::post('/admin/login', [adminAuthController::class, 'signin'])->name('admin.signin');
    });

    Route::group(['middleware' => 'admin'], function () {
        Route::get('/admin', [adminIndexController::class, 'index'])->name('admin.index');

        Route::get('/admin/store/data-items', [DataItemsController::class, 'index'])->name('admin.store.data-items');
        Route::get('/admin/store/data-items/{id}', [DataItemsController::class, 'update'])->name('admin.store.data-items.update');
        Route::patch('/admin/store/data-items/edit', [DataItemsController::class, 'updateItem'])->name('admin.store.data-items.update-item');
        Route::patch('/admin/store/data-items/delete/{id}', [DataItemsController::class, 'deleteItem'])->name('admin.store.data-items.delete-item');

        Route::get('/admin/store/make-items', [MakeItemsController::class, 'index'])->name('admin.store.make-items');
        Route::post('/admin/store/make-items', [MakeItemsController::class, 'store'])->name('admin.store.make-items.submit');

        Route::get('/admin/store/payment-items', [PaymentItemsController::class, 'index'])->name('admin.store.payment-items');
        Route::patch('/admin/store/payment-items/success/{id}', [PaymentItemsController::class, 'success'])->name('admin.store.payment-items.success');
        Route::patch('/admin/store/payment-items/delete/{id}', [PaymentItemsController::class, 'delete'])->name('admin.store.payment-items.delete');

        Route::post('/admin/store/payment-items/make/payment', [PaymentItemsController::class, 'makePayment'])->name('admin.make.payment');
        Route::patch('/admin/store/payment-items/payment/delete/{id}', [PaymentItemsController::class, 'deletePayment'])->name('admin.delete.payment');
        Route::patch('/admin/store/payment-items/payment/edit', [PaymentItemsController::class, 'editPayment'])->name('admin.edit.payment');

        Route::post('/admin/store/make-category', [MakeCategoryController::class, 'store'])->name('admin.store.make-category.submit');

        Route::get('/admin/user/data', [UserDataController::class, 'index'])->name('admin.user.data');
        Route::get('/admin/user/checkout', [UserCheckoutController::class, 'index'])->name('admin.user.checkout');

        Route::post('/admin/logout', [adminAuthController::class, 'logout'])->name('admin.logout');
    });
});
