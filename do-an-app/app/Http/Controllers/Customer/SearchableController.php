<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Repositories\CategoryServiceRepository;
use App\Repositories\LocationRepository;
use App\Repositories\SalonRepository;
use App\Repositories\ServiceRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SearchableController extends Controller
{
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


    public function index()
    {
        $provinces =  $this->locationRepository->getAllProvince();
        $services = Service::query()
            ->select('name')
            ->where('status', 'active')
            ->groupBy('name')
            ->orderBy('name', 'asc')
            ->get();
        return view('components.customer.search.searchable', compact('provinces', 'services'));
    }

    public function searchable(Request $request) {
        $salonName = $request['salonName'] ?? null;
        $serviceName = $request['serviceName'] ?? null;
        $provinceName = $request['province'] ?? null;
        $districtName = $request['district'] ?? null;
        $wardName = $request['ward'] ?? null;
        $starRating = $request['star'] ?? 0;
        

        $salons = DB::select('CALL CustomerSearchableSalon(:salonName, :serviceName, :provinceName, :districtName, :wardName, :starRating)', [
            'salonName' => $salonName,
            'serviceName' => $serviceName,
            'provinceName' => $provinceName,
            'districtName' => $districtName,
            'wardName' => $wardName,
            'starRating' => $starRating
        ]);


        if($salons) {
            foreach ($salons as $salon) {
                $salon->location = $this->locationRepository
                    ->getAddress($salon->ward_code);
                $resultStar = DB::select('CALL GetTotalStarBySalonID(?)', [$salon->salon_id]);
                $salon->star = $resultStar[0]->average_stars ?? 0;
            }
        }


        return $salons;
    }
}
