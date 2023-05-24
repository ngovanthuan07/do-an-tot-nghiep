<?php

namespace App\Providers;

use App\Repositories\AppointmentRepository;
use App\Repositories\CategoryServiceRepository;
use App\Repositories\EmployeeRepository;
use App\Repositories\EmployeeWorkScheduleRepository;
use App\Repositories\LocationRepository;
use App\Repositories\PaymentServiceRepository;
use App\Repositories\SalonRepository;
use App\Repositories\ServiceDetailRepository;
use App\Repositories\ServiceRepository;
use App\Repositories\WorkScheduleRepository;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(SalonRepository::class, function (Application $app) {
            return new SalonRepository();
        });

        $this->app->bind(LocationRepository::class, function (Application $app) {
            return new LocationRepository();
        });

        $this->app->bind(CategoryServiceRepository::class, function (Application $app) {
            return new CategoryServiceRepository();
        });

        $this->app->bind(ServiceRepository::class, function (Application $app) {
            return new ServiceRepository();
        });

        $this->app->bind(EmployeeRepository::class, function (Application $app) {
            return new EmployeeRepository();
        });

        $this->app->bind(EmployeeWorkScheduleRepository::class, function (Application $app) {
            return new EmployeeWorkScheduleRepository();
        });

        $this->app->bind(WorkScheduleRepository::class, function (Application $app) {
            return new WorkScheduleRepository();
        });

        $this->app->bind(AppointmentRepository::class, function (Application $app) {
            return new AppointmentRepository();
        });

        $this->app->bind(ServiceDetailRepository::class, function (Application $app) {
            return new ServiceDetailRepository();
        });

        $this->app->bind(PaymentServiceRepository::class, function (Application $app) {
            return new PaymentServiceRepository();
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
