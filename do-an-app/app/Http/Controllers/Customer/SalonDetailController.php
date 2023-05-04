<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Repositories\CategoryServiceRepository;
use App\Repositories\LocationRepository;
use App\Repositories\SalonRepository;
use App\Repositories\ServiceRepository;
use Illuminate\Http\Request;

class SalonDetailController extends Controller
{
    /**
     * @var SalonRepository
     */
    private $salonRepository;
    /**
     * @var CategoryServiceRepository
     */
    private $categoryServiceRepository;
    /**
     * @var ServiceRepository
     */
    private $serviceRepository;
    /**
     * @var LocationRepository
     */
    private $locationRepository;

    public function __construct(
        SalonRepository $salonRepository,
        CategoryServiceRepository $categoryServiceRepository,
        ServiceRepository $serviceRepository,
        LocationRepository $locationRepository
    )
    {
        $this->salonRepository = $salonRepository;
        $this->categoryServiceRepository = $categoryServiceRepository;
        $this->serviceRepository = $serviceRepository;
        $this->locationRepository = $locationRepository;
    }

    public function index(Request $request) {
        $salon = $this->salonRepository->getSalonById($request['id']);
        $salon->images = $salon->getImages();
        $salon['categoryService'] = $this->categoryServiceRepository
            ->getAllCategoryServiceBySalonId($salon->salon_id);
        $salon['location'] = $this->locationRepository
            ->getAddress($salon->ward_code);
        if(!empty($salon['categoryService'])) {
            foreach ($salon['categoryService'] as $cse) {
                $cse['services'] = $this->serviceRepository
                    ->getServiceByCategoryServiceIDAndSalonID($cse->cse_id,$salon->salon_id);
            }
        }
        $services = $this->serviceRepository
            ->getAllServiceBySalonId($salon->salon_id);

        return view('components.customer.salon-details.salon-detail', compact('salon', 'services'));
    }

    public function getServiceByCategoryServiceIDAndSalonID(Request $request)
    {
        return $this->serviceRepository
            ->getServiceByCategoryServiceIDAndSalonID($request['cse_id'],$request['salon_id']);
    }

    public function getServiceBySalonID(Request $request)
    {
        return $this->serviceRepository
            ->getAllServiceBySalonId($request['salon_id']);
    }
}
