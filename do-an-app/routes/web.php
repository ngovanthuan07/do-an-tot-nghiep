<?php

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
