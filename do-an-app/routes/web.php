<?php

use App\Http\Controllers\Customer\AccountController;
use App\Http\Controllers\Customer\AppointmentController;
use App\Http\Controllers\Customer\Auth\FacebookAuthController;
use App\Http\Controllers\Customer\Auth\GoogleAuthController;
use App\Http\Controllers\Customer\Auth\LoginController;
use App\Http\Controllers\Customer\CommentController;
use App\Http\Controllers\Customer\HandleBookController;
use App\Http\Controllers\Customer\HandlePaymentControlller;
use App\Http\Controllers\Customer\HomeController;
use App\Http\Controllers\Customer\PostController;
use App\Http\Controllers\Customer\SearchableController;
use App\Http\Controllers\Customer\SessionBookingController;
use App\Http\Controllers\Customer\SalonDetailController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\TestController;
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
\Debugbar::disable();

Route::get('provinces/getAll', [LocationController::class, 'getAllProvince'])->name('provinces.getAll');
Route::get('provinces/getByCode/{code}', [LocationController::class, 'getProvinceByCode'])->name('provinces.getByCode');

Route::get('districts/getByProvince/{provinceCode}', [LocationController::class, 'getByDistrictByProvinceCode'])->name('districts.getByProvince');

Route::get('wards/getByDistrict/{districtCode}', [LocationController::class, 'getByWardByDistrictCode'])->name('wards.getByDistrict');

Route::get('locationAddress/{wardCode}', [LocationController::class, 'address'])->name('locationAddress');


Route::get('/', [HomeController::class, 'index'])->name('customer.home');
Route::get('/lam-dep/{id}/chi-tiet-salon', [SalonDetailController::class, 'index'])->name('customer.salon-page.detail');
Route::get('/lam-dep/get-service-by-category-service-and-salon-id', [SalonDetailController::class, 'getServiceByCategoryServiceIDAndSalonID'])->name('customer.salon-page.get-service-by-category-service-and-salon-id');
Route::get('/lam-dep/get-service-by-salon-id', [SalonDetailController::class, 'getServiceBySalonID'])->name('customer.salon-page.get-service-by-salon-id');

Route::get('/lam-dep/get-service-by-salon-id', [SalonDetailController::class, 'getServiceBySalonID'])->name('customer.login');

/** Login **/
Route::get('/dang-nhap', [LoginController::class, 'login'])->name('dang-nhap');
Route::get('/auth/google/redirect', [GoogleAuthController::class, 'redirectToProvider'])->name('google.redirect');
Route::get('/auth/google/callback', [GoogleAuthController::class, 'handleProviderCallback'])->name('google.callback');
Route::get('/auth/facebook/redirect', [FacebookAuthController::class, 'redirectToProvider'])->name('facebook.redirect');
Route::get('/auth/facebook/callback', [FacebookAuthController::class, 'handleProviderCallback'])->name('facebook.callback');


// search
Route::get('/lam-dep', [SearchableController::class, 'index'])->name('customer.salon.search_view');
Route::get('/lam-dep/searchable', [SearchableController::class, 'searchable'])->name('customer.salon.searchable');

/** End Login **/
Route::middleware(['customer.auth'])->group(function () {

    //book
    Route::get('/lam-dep/{id}/dat-lich', [HandleBookController::class, 'index'])->name('customer.salon-page.book');
    Route::get('/lam-dep/{id}/dat-lich/ngay-lam-viec', [HandleBookController::class, 'workDate'])->name('customer.salon-page.book.workDate');
    Route::get('/lam-dep/{id}/dat-lich/nhan-vien-lam-viec', [HandleBookController::class, 'employeeWord'])->name('customer.salon-page.book.employeeWord');
    Route::post('/lam-dep/{id}/dat-lich/luu-vao-session', [SessionBookingController::class, 'sessionPayment'])->name('customer.salon-page.book.sessionPayment');
    Route::get('/lam-dep/{id}/dat-lich/thanh-toan', [SessionBookingController::class, 'dPayment'])->name('customer.salon-page.book.dPayment');

    // checkout-service
    Route::post('/dat-lich/thanh-toan/redirect_url_payment', [HandlePaymentControlller::class, 'link_redirect'])->name('customer.payment.book.redirect_url_payment');
    Route::get('/dat-lich/thanh-toan/tien_mat', [HandlePaymentControlller::class, 'payment_pay_with_cash'])->name('customer.payment.book.payment_pay_with_cash');
    Route::get('/dat-lich/thanh-toan/momo', [HandlePaymentControlller::class, 'payment_pay_with_momo'])->name('customer.payment.book.payment_pay_with_momo');

    //comment
    Route::post('/salon-comment/add', [CommentController::class, 'addComment']);
    // profile
    Route::get('/me', [LoginController::class, 'me'])->name('customer.me');
    Route::get('/profile', [AccountController::class, 'profile'])->name('customer.profile');
    Route::post('/profile', [AccountController::class, 'updateProfile'])->name('customer.profile.update');
    Route::get('/logout', [LoginController::class, 'logout'])->name('customer.logout');

    // appointment
    Route::get('/lich-hen', [AppointmentController::class, 'appointment'])->name('customer.appointment');
    Route::get('/lich-hen/huy-cuoc-hen/{appointment_id}', [AppointmentController::class, 'cancel'])->name('customer.appointment.cancel');

});

Route::get('/dat-lich/thanh-toan/momo-return', [HandlePaymentControlller::class, 'payment_pay_with_return_momo'])->name('customer.payment.book.momo-return');
Route::get('/bai-viet/{post_id}', [PostController::class, 'post'])->name('customer.my-post');

Route::get('testMail', [TestController::class, 'testMail']);
Route::get('check-user-comment', [TestController::class, 'test']);
