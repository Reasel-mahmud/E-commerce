<?php

use App\Http\Controllers\{CategoryController, FrontendController, HomeController, SubcategoryController, ProductController, BannerController, CartController, CheckoutController, CouponController, CustomerController, SslCommerzPaymentController};

use Illuminate\Support\Facades\{Auth, Route};

// Auth Routes Start //
Auth::routes();
// Auth Routes End //

// FrontendController Routes Start //
Route::get('/', [FrontendController::class, 'index'])->name('index');
Route::get('shop', [FrontendController::class, 'shop'])->name('shop');
Route::get('category/details/{slug}', [FrontendController::class, 'categorydetails'])->name('category.details');
Route::get('product/details/{slug}', [FrontendController::class, 'productdetails'])->name('product.details');
Route::post('get/size', [FrontendController::class, 'getsize'])->name('get.size');
Route::post('get/stock', [FrontendController::class, 'getstock'])->name('get.stock');
Route::post('add/to/cart', [FrontendController::class, 'addtocart'])->name('add.to.cart');
Route::post('get/city', [FrontendController::class, 'getcity'])->name('get.city');
Route::post('check/coupon', [FrontendController::class, 'checkcoupon'])->name('check.coupon');
Route::post('checkout/redirect', [FrontendController::class, 'checkoutredirect'])->name('checkout.redirect');
Route::get('order/invoice/{order_id}', [FrontendController::class, 'orderinvoice'])->name('order.invoice');
Route::get('order/invoice/download/{order_id}', [FrontendController::class, 'order_invoice_download'])->name('order.invoice.download');
// FrontendController Routes End //

// CheckoutController Routes End //
Route::get('checkout', [CheckoutController::class, 'checkout'])->name('checkout');
Route::post('checkout/post', [CheckoutController::class, 'checkoutpost'])->name('checkout.post');
// CheckoutController Routes End //

// CustomerController Routes End //
Route::get('customer', [CustomerController::class, 'customer'])->name('customer');
Route::post('customer/register', [CustomerController::class, 'customerregister'])->name('customer.register');
Route::get('customer/dashboard', [CustomerController::class, 'customerdashboard'])->name('customer.dashboard');
Route::get('reload-captcha', [CustomerController::class, 'reloadcaptcha'])->name('reload.captcha');
// CustomerController Routes End //

// HomeController Routes Start //
Route::get('profile', [HomeController::class, 'profile'])->name('profile');
Route::get('home', [HomeController::class, 'index'])->name('home');
Route::post('change/password', [HomeController::class, 'changepassword'])->name('change.password');
Route::post('change/name', [HomeController::class, 'changename'])->name('change.name');
Route::get('shipping', [HomeController::class, 'shipping'])->name('shipping');
Route::post('add/shipping', [HomeController::class, 'addshipping'])->name('add.shipping');
Route::get('coupon', [HomeController::class, 'coupon'])->name('coupon');
Route::get('order', [HomeController::class, 'order'])->name('order');
Route::get('order/change/status/{order_id}/{delivery_status}', [HomeController::class, 'orderchangestatus'])->name('order.change.status');
// HomeController Routes End //

// CartController Routes Start //
Route::get('cart', [CartController::class, 'cart'])->name('cart');
Route::get('remove/cart/{cart}', [CartController::class, 'removecart'])->name('remove.cart');
Route::get('clear/cart', [CartController::class, 'clearcart'])->name('clear.cart');
Route::post('update/cart', [CartController::class, 'updatecart'])->name('update.cart');
// CartController Routes End //


// CategoryController Routes Start //
Route::resource('category', CategoryController::class);
Route::delete('category/delete/{category}', [CategoryController::class, 'harddelete'])->name('category.harddelete');
// CategoryController Routes End //

// SubcategoryController Routes Start //
Route::resource('subcategory', SubcategoryController::class);
// SubcategoryController Routes End //

// ProductController Routes Start //
Route::middleware(['auth', 'checkrole'])->group(function () {
    Route::resource('product', ProductController::class);
    Route::post('get/subcategory', [ProductController::class, 'getsubcategory'])->name('get.subcategory');
    Route::get('color', [ProductController::class, 'color'])->name('product.color');
    Route::post('product/color/store', [ProductController::class, 'colorstore'])->name('product.color.store');
    Route::get('size', [ProductController::class, 'size'])->name('product.size');
    Route::post('product/size/store', [ProductController::class, 'sizestore'])->name('product.size.store');
    Route::get('product/inventory/{product_id}', [ProductController::class, 'inventory'])->name('product.inventory');
    Route::post('product/inventory/store/{product_id}', [ProductController::class, 'inventorystore'])->name('product.inventory.store');
});
// ProductController Routes End //

// BannerController Routes Start //
Route::resource('banner', BannerController::class);
// BannerController Routes End //

// BannerController Routes Start //
Route::resource('coupon', CouponController::class);
// BannerController Routes End //

// SSLCOMMERZ Start
Route::get('/example1', [SslCommerzPaymentController::class, 'exampleEasyCheckout']);
Route::get('/example2', [SslCommerzPaymentController::class, 'exampleHostedCheckout']);

Route::get('/pay', [SslCommerzPaymentController::class, 'index'])->name('pay');
Route::post('/pay-via-ajax', [SslCommerzPaymentController::class, 'payViaAjax']);

Route::post('/success', [SslCommerzPaymentController::class, 'success']);
Route::post('/fail', [SslCommerzPaymentController::class, 'fail']);
Route::post('/cancel', [SslCommerzPaymentController::class, 'cancel']);

Route::post('/ipn', [SslCommerzPaymentController::class, 'ipn']);
//SSLCOMMERZ END



