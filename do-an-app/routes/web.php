<?php

use App\Http\Controllers\Customer\AccountController;
use App\Http\Controllers\Customer\Auth\GoogleAuthController;
use App\Http\Controllers\Customer\Auth\LoginController;
use App\Http\Controllers\Customer\BookController;
use App\Http\Controllers\Customer\HomeController;
use App\Http\Controllers\Customer\PaymentBookingController;
use App\Http\Controllers\Customer\SalonDetailController;
use App\Http\Controllers\LocationController;
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
/** End Login **/
Route::middleware(['customer.auth'])->group(function () {
    //book
    Route::get('/lam-dep/{id}/dat-lich', [BookController::class, 'index'])->name('customer.salon-page.book');
    Route::get('/lam-dep/{id}/dat-lich/ngay-lam-viec', [BookController::class, 'workDate'])->name('customer.salon-page.book.workDate');
    Route::get('/lam-dep/{id}/dat-lich/nhan-vien-lam-viec', [BookController::class, 'employeeWord'])->name('customer.salon-page.book.employeeWord');
    Route::post('/lam-dep/{id}/dat-lich/luu-vao-session', [PaymentBookingController::class, 'sessionPayment'])->name('customer.salon-page.book.sessionPayment');
    Route::get('/lam-dep/{id}/dat-lich/thanh-toan', [PaymentBookingController::class, 'dPayment'])->name('customer.salon-page.book.dPayment');


    // profile
    Route::get('/me', [LoginController::class, 'me'])->name('customer.me');
    Route::get('/profile', [AccountController::class, 'profile'])->name('customer.profile');
    Route::post('/profile', [AccountController::class, 'updateProfile'])->name('customer.profile.update');
    Route::get('/logout', [LoginController::class, 'logout'])->name('customer.logout');
});
