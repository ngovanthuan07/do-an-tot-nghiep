<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Salon\AddSalonRequest;
use App\Http\Requests\Admin\Salon\EditSalonRequest;
use App\Models\Salon;
use App\Repositories\LocationRepository;
use App\Repositories\SalonRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class SalonController extends Controller
{
    protected $locationRepository;
    protected $salonRepository;

    public function __construct(
        SalonRepository $salonRepository,
        LocationRepository $locationRepository
    )
    {
        $this->locationRepository = $locationRepository;
        $this->salonRepository = $salonRepository;
    }

    public function displaySalons()
    {
        return view('components.admin.account-salon.list-salon');
    }

    public function displaySalonBlock()
    {
        return view('components.admin.account-salon.list-salon-block');
    }

    public function displayEditSalon(Request $request) {
        $salon = $this->salonRepository->getSalonById($request['salonId']);
        $provinces =  $this->locationRepository->getAllProvince();

        if($salon) {
            $location = $this->locationRepository->getAddress($salon->ward_code);
            $districts = $this->locationRepository->getByDistrictByProvinceCode($location['province']->code);
            $wards = $this->locationRepository->getByWardByDistrictCode($location['district']->code);

            return view('components.admin.account-salon.edit-salon',
                compact('salon','provinces','location', 'districts', 'wards'));
        }
    }

    public function apiDisplaySalonActive() {
        return $this->salonRepository->getAllSalonStatusOn();
    }

    public function apiDisplaySalonBlock() {
        return $this->salonRepository->getAllSalonStatusBlock();
    }

    public function displayAddSalon() {
        $provinces =  $this->locationRepository->getAllProvince();
        return view('components.admin.account-salon.add-salon', compact('provinces'));
    }

    public function store(Request $request) {
        $salon = $this->salonRepository->adminSaveSalon($request);
        return response()->json([
            "salon" => $salon,
            "success" => true
        ]);
    }



    public function validateStore(AddSalonRequest $request) {
        return response()->json([
            "success" => true
        ]);
    }

    public function validateUpdate(EditSalonRequest $request) {
        return response()->json([
            "success" => true
        ]);
    }

    public function changeStatus(Request $request) {
        $success = $this->salonRepository->salonStatus($request);

        return response()->json(
            [
                'success' => $success
            ]
        );
    }

    public function update(Request $request) {
        $salon = $this->salonRepository->adminUpdateSalon($request);
        return response()->json([
            "salon" => $salon,
            "success" => true
        ]);
    }

    public function destroy() {

    }

}
