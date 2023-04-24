<?php

use App\Http\Controllers\Admin\AuthAdminController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\SalonController;
use App\Http\Controllers\Salon\AuthSalonController;
use App\Http\Controllers\Salon\CategoryServiceController;
use App\Http\Controllers\Salon\ServiceController;
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

Route::middleware(['salon.auth'])->prefix('salon')->group(function () {
    Route::get('/', [\App\Http\Controllers\Salon\DashboardController::class, 'index'])->name('salon.dashboard');


    // category service
    Route::prefix('category-service')->group(function () {
        //list
        Route::get('all', [CategoryServiceController::class, 'apiCategoryServices'])->name('salon.categoryservice.all');
        Route::get('display-category-service-all', [CategoryServiceController::class, 'displayCategoryServices'])->name('salon.categoryservice.display-all');

        // add
        Route::get('/display-add', [CategoryServiceController::class, 'displayAddCategoryService'])->name('salon.categoryservice.displayAdd');
        Route::post('/store', [CategoryServiceController::class, 'store'])->name('salon.categoryservice.store');

        //update
        Route::get('/display-update/{id}', [CategoryServiceController::class, 'displayUpdateCategoryService'])->name('salon.categoryservice.displayUpdate');
        Route::post('/update', [CategoryServiceController::class, 'update'])->name('salon.categoryservice.update');
        Route::post('/updateStatus', [CategoryServiceController::class, 'updateStatus'])->name('salon.categoryservice.updateStatus');


        // valid
        Route::post('/validated-category', [CategoryServiceController::class, 'validateCategory'])->name('salon.categoryservice.validated-category');
    });

    //service
    Route::prefix('service')->group(function () {
        //list
        Route::get('/all', [ServiceController::class, 'apiAllService'])->name('salon.service.all');
        Route::get('/displayServices', [ServiceController::class, 'displayServices'])->name('salon.service.displayServices');

        //add
        Route::get('/display-add', [ServiceController::class, 'displayAdd'])->name('salon.service.displayAdd');
        Route::post('/validation-store', [ServiceController::class, 'validateStore'])->name('salon.service.validateStore');
        Route::post('/store', [ServiceController::class, 'store'])->name('salon.service.store');

        //update
        Route::get('/display-update/{id}', [ServiceController::class, 'displayUpdate'])->name('salon.service.displayUpdate');
        Route::post('/validation-update', [ServiceController::class, 'validateUpdate'])->name('salon.service.validateUpdate');
        Route::post('/update', [ServiceController::class, 'update'])->name('salon.service.update');

        // delete
        Route::post('/delete', [ServiceController::class, 'delete'])->name('salon.service.delete');
    });



    Route::get('/logout', [AuthSalonController::class, 'logout'])->name('salon.logout');
});

Route::get('/salonLogin', [AuthSalonController::class, 'displaySalonLogin'])->name('salon.displaySalonLogin');
Route::post('/salonLogin', [AuthSalonController::class, 'salonLogin'])->name('salon.salonLogin');

