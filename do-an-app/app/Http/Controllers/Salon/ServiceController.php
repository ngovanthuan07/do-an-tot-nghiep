<?php

namespace App\Http\Controllers\Salon;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Salon\EditSalonRequest;
use App\Http\Requests\Salon\AddServiceRequest;
use App\Http\Requests\Salon\EditServiceRequest;
use App\Models\CategoryService;
use App\Repositories\CategoryServiceRepository;
use App\Repositories\ServiceRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ServiceController extends Controller
{
    /**
     * @var CategoryServiceRepository
     */
    private $categoryServiceRepository;
    /**
     * @var ServiceRepository
     */
    private $serviceRepository;

    public function __construct(
        CategoryServiceRepository $categoryServiceRepository,
        ServiceRepository $serviceRepository
    )
    {
        $this->categoryServiceRepository = $categoryServiceRepository;
        $this->serviceRepository = $serviceRepository;
    }

    public function apiAllService() {
        $services = $this->serviceRepository->getAllServiceBySalonId(Auth::guard('salon')->user()->salon_id);
        return $services;
    }

    public function displayServices() {
        return view('components.salon.service.list-service',);
    }


    public function displayAdd() {
        $categoryServices = $this->categoryServiceRepository->getAllCategoryServiceBySalonId(
            Auth::guard('salon')->user()->salon_id
        );
        return view('components.salon.service.add-service',
            compact('categoryServices')
        );
    }

    public function validateStore(AddServiceRequest $request) {
        return response()->json([
            'success' => true
        ]);
    }

    public function store(Request $request) {
        $service = $this->serviceRepository->create($request);

        return response()->json([
            'success' => true
        ]);
    }

    public function displayUpdate(Request $request) {
        $categoryServices = $this->categoryServiceRepository->getAllCategoryServiceBySalonId(
            Auth::guard('salon')->user()->salon_id
        );
        $service = $this->serviceRepository->getServiceByIdServiceAndSalon(
            $request['id'],
            Auth::guard('salon')->user()->salon_id
        );

        return view('components.salon.service.edit-service',
            compact('categoryServices', 'service')
        );
    }

    public function validateUpdate(EditServiceRequest $request) {
        return response()->json([
            'success' => true
        ]);
    }

    public function update(Request $request) {
        $service = $this->serviceRepository->update($request, Auth::guard('salon')->user()->salon_id);

        return response()->json([
            'success' => true
        ]);
    }

    public function delete(Request $request) {
        $service = $this->serviceRepository->updateStatus($request, $request->input('service_id'));

        return response()->json([
            'success' => true
        ]);
    }
}
