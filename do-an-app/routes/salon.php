<?php

use App\Http\Controllers\Admin\AuthAdminController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\SalonController;
use App\Http\Controllers\salon\AppointmentController;
use App\Http\Controllers\Salon\AuthSalonController;
use App\Http\Controllers\Salon\CategoryServiceController;
use App\Http\Controllers\Salon\CommentController;
use App\Http\Controllers\Salon\EmployeeController;
use App\Http\Controllers\Salon\ProfileController;
use App\Http\Controllers\Salon\ServiceController;
use App\Http\Controllers\Salon\StatisticalController;
use App\Http\Controllers\Salon\WorkScheduleController;
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


    //employee
    Route::prefix('employee')->group(function () {
        //list
        Route::get('/all', [EmployeeController::class, 'apiEmployeeAll'])->name('salon.employee.all');
        Route::get('/displayEmployees', [EmployeeController::class, 'displayEmployees'])->name('salon.employee.displayEmployees');


        //add
        Route::get('/display-add', [EmployeeController::class, 'displayAdd'])->name('salon.employee.displayAdd');
        Route::post('/validation-store', [EmployeeController::class, 'validateStore'])->name('salon.employee.validateStore');
        Route::post('/store', [EmployeeController::class, 'store'])->name('salon.employee.store');


        //update
        Route::get('/display-update/{id}', [EmployeeController::class, 'displayUpdate'])->name('salon.employee.displayUpdate');
        Route::post('/validation-update', [EmployeeController::class, 'validateUpdate'])->name('salon.employee.validateUpdate');
        Route::post('/update', [EmployeeController::class, 'update'])->name('salon.employee.update');


        // delete
        Route::post('/delete', [EmployeeController::class, 'updateStatus'])->name('salon.employee.delete');

        //work-schedule
        Route::get('/work-schedule', [EmployeeController::class, 'workScheduleDisplay'])->name('salon.employee.work-schedule');
        Route::get('/work-schedule-date', [EmployeeController::class, 'workScheduleGetByDate'])->name('salon.employee.work-schedule-date');
        Route::post('/work-schedule-save', [EmployeeController::class, 'workScheduleSave'])->name('salon.employee.work-schedule-save');
    });

    Route::prefix('schedule')->group(function () {
        Route::get('/work-schedule', [WorkScheduleController::class, 'workScheduleDisplaySalon'])->name('salon.schedule.work-schedule');
        Route::get('/work-schedule-date', [WorkScheduleController::class, 'workScheduleGetByDate'])->name('salon.schedule.work-schedule-date');
        Route::post('/work-schedule-save', [WorkScheduleController::class, 'workScheduleSalonSave'])->name('salon.schedule.work-schedule-save');

    });

    // appointment
    Route::prefix('appointment')->group(function () {
        Route::get('/cuoc-hen-chua-xac-nhan', [AppointmentController::class, 'scheduled'])->name('salon.appointment.lSchedule');
        Route::get('/da-xac-nhan', [AppointmentController::class, 'confirmed'])->name('salon.appointment.lConfirmed');
        Route::get('/da-hoan-thanh', [AppointmentController::class, 'completed'])->name('salon.appointment.lCompleted');
        Route::get('/da-huy', [AppointmentController::class, 'cancel'])->name('salon.appointment.lCancel');
        Route::get('/list-appointment-by-status', [AppointmentController::class, 'loadAppointmentByStatus'])->name('salon.appointment.loadAppointmentByStatus');
        Route::get('/chi-tiet-cuoc-hen/{appointment_id}', [AppointmentController::class, 'detailAppointment'])->name('salon.appointment.detailAppointment');
        Route::post('/chi-tiet-cuoc-hen/cap-nhat-trang-thai', [AppointmentController::class, 'updateStatus'])->name('salon.appointment.updateStatus');
    });

    Route::prefix('profile')->group(function () {
        // update profile
        Route::get('/display-profile', [ProfileController::class, 'displayProfile'])->name('salon.profile.display-profile');
        Route::post('/validate-update', [ProfileController::class, 'validateUpdate'])->name('salon.profile.validate-update');
        Route::post('/update', [ProfileController::class, 'update'])->name('salon.profile.update');


        //update images
        Route::get('/salon-images', [ProfileController::class, 'loadSalonImage'])->name('salon.profile.salon-images');
        Route::get('/display-images', [ProfileController::class, 'displayImages'])->name('salon.profile.display-images');
        Route::post('/images-save', [ProfileController::class, 'imagesSave'])->name('salon.profile.images-save');

        // time desc
        Route::get('/time-desc', [ProfileController::class, 'timeDesc'])->name('salon.profile.time-desc');
        Route::post('/validate-time-desc-update', [ProfileController::class, 'timeValidate'])->name('salon.profile.validate-time-desc-update');
        Route::post('/time-desc-update', [ProfileController::class, 'timeDescUpdate'])->name('salon.profile.time-desc-update');

    });

    Route::prefix('comment')->group(function () {
        Route::get('/danh-sach-binh-luan', [CommentController::class, 'lComment'])->name('salon.comment.lComment');
        Route::get('/binh-luan-api', [CommentController::class, 'commentApi'])->name('salon.comment.commentApi');
        Route::get('/xoa-binh-luan/{comment_id}', [CommentController::class, 'commentDelete'])->name('salon.comment.delete');
    });

    Route::prefix('statistic')->group(function () {
        Route::get('/top_nhan_vien', [StatisticalController::class, 'top_nhan_vien'])->name('salon.statistic.top_nhan_vien');
        Route::get('/top_nhan_vien_api', [StatisticalController::class, 'top_nhan_vien_api'])->name('salon.statistic.top_nhan_vien_api');

    });

    Route::get('/logout', [AuthSalonController::class, 'logout'])->name('salon.logout');
});

Route::get('/salonLogin', [AuthSalonController::class, 'displaySalonLogin'])->name('salon.displaySalonLogin');
Route::post('/salonLogin', [AuthSalonController::class, 'salonLogin'])->name('salon.salonLogin');

