<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Customer;
use App\Repositories\CategoryServiceRepository;
use App\Repositories\LocationRepository;
use App\Repositories\SalonRepository;
use App\Repositories\ServiceRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

        $comments = Comment::where('salon_id', $salon->salon_id)->get();
        foreach ($comments as $comment) {
            $comment['customer'] = Customer::where('customer_id', $comment->customer_id)->first();
        }

        $resultStar = DB::select('CALL GetTotalStarBySalonID(?)', [$salon->salon_id]);

        $stars = $resultStar[0]->average_stars ?? 0;

        return view('components.customer.salon-details.salon-detail', compact('salon', 'services', 'comments', 'stars'));
    }

    public function getServiceByCategoryServiceIDAndSalonID(Request $request)
    {
        return DB::select('CALL GetServicesByCseIdAndSalonId(?, ?)', [$request['cse_id'],$request['salon_id']]);
//        return $this->serviceRepository
//            ->getServiceByCategoryServiceIDAndSalonID($request['cse_id'],$request['salon_id']);
    }

    public function getServiceBySalonID(Request $request)
    {
        return DB::select('CALL GetServicesBySalonId(?)', [$request['salon_id']]);
//        return $this->serviceRepository
//            ->getAllServiceBySalonId($request['salon_id']);
    }
}
