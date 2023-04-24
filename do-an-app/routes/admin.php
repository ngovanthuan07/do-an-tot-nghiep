<?php

use App\Http\Controllers\Admin\AuthAdminController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\SalonController;
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

Route::middleware(['admin.auth'])->prefix('admin')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('admin.dashboard');

    Route::prefix('salons')->group(function () {
        Route::get('/', [SalonController::class, 'displaySalons'])->name('admin.salons');
        Route::get('/displayAddSalon', [SalonController::class, 'displayAddSalon'])->name('admin.salons.displayAddSalon');
        Route::post('/store', [SalonController::class, 'store'])->name('admin.salons.add');
        Route::post('/update', [SalonController::class, 'update'])->name('admin.salons.update');

        Route::get('/displayEditSalon/{salonId}', [SalonController::class, 'displayEditSalon'])->name('admin.salons.displayEdit');

        Route::get('/delete/{id}')->name('admin.salons.delete');

        Route::get('/display-salon-block', [SalonController::class, 'displaySalonBlock'])->name('admin.salons.displaySalonBlock');
        // validate
        Route::post('/validate-store', [SalonController::class, 'validateStore']);
        Route::post('/validate-update', [SalonController::class, 'validateUpdate']);
        // api
        Route::get('/get-all-salon', [SalonController::class, 'apiDisplaySalonActive'])->name('admin.salons.getAllSalon');
        Route::get('/get-all-salon-block', [SalonController::class, 'apiDisplaySalonBlock'])->name('admin.salons.getAllSalonBlock');
        Route::post('/block-action', [SalonController::class, 'changeStatus'])->name('admin.salons.blockAction');
    });







    Route::get('/logout', [AuthAdminController::class, 'logout'])->name('admin.logout');
});

Route::get('/adminLogin', [AuthAdminController::class, 'displayAdminLogin'])->name('admin.displayAdminLogin');
Route::post('/adminLogin', [AuthAdminController::class, 'adminLogin'])->name('admin.adminLogin');

