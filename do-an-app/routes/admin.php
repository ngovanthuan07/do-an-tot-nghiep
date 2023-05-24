<?php

use App\Http\Controllers\Admin\AuthAdminController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\SalonController;
use App\Http\Controllers\Admin\Setting\OutstandingController;
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


    Route::prefix('settings')->group(function () {
        Route::get('/outstanding',[OutstandingController::class, 'index'])->name('admin.outstanding.index');
        Route::get('/listSalonNotOutstanding',[OutstandingController::class, 'listSalonNotOutstanding'])->name('admin.outstanding.listSalonNotOutstanding');
        Route::get('/listSalonOutstanding',[OutstandingController::class, 'listSalonOutstanding'])->name('admin.outstanding.listSalonOutstanding');
        Route::post('/addOutstanding',[OutstandingController::class, 'addOutstanding'])->name('admin.outstanding.addOutstanding');
        Route::post('/removeOutstanding',[OutstandingController::class, 'removeOutstanding'])->name('admin.outstanding.removeOutstanding');
    });

    Route::prefix('posts')->group(function () {
        // post
        Route::get('/', [PostController::class, 'index'])->name('admin.posts.index');
        Route::get('/them-bai-viet', [PostController::class, 'showAdd'])->name('admin.posts.showAdd');
        Route::post('/them', [PostController::class, 'save'])->name('admin.posts.save');
        Route::get('/chinh-sua-bai-viet/{post_id}', [PostController::class, 'showUpdate'])->name('admin.posts.showUpdate');
        Route::post('/cap-nhat', [PostController::class, 'update'])->name('admin.posts.update');
        Route::get('/danh-sach-bai-viet-api', [PostController::class, 'listPostApi'])->name('admin.posts.listPostApi');
        Route::post('/xoa-bai-viet', [PostController::class, 'delete'])->name('admin.posts.delete');
    });







    Route::get('/logout', [AuthAdminController::class, 'logout'])->name('admin.logout');
});

Route::get('/adminLogin', [AuthAdminController::class, 'displayAdminLogin'])->name('admin.displayAdminLogin');
Route::post('/adminLogin', [AuthAdminController::class, 'adminLogin'])->name('admin.adminLogin');

