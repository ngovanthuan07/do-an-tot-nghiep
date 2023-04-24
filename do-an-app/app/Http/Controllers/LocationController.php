<?php

namespace App\Http\Controllers;

use App\Repositories\LocationRepository;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    protected $locationRepository;

    public function __construct(LocationRepository $locationRepository)
    {
        $this->locationRepository = $locationRepository;
    }

    public function getAllProvince() {
        return $this->locationRepository->getAllProvince();
    }

    public function getProvinceByCode(Request $request)
    {
        return $this->locationRepository->getProvinceByCode($request['code']);
    }

    public function getByDistrictByProvinceCode(Request $request) {
        return $this->locationRepository->getByDistrictByProvinceCode($request['provinceCode']);
    }

    public function getByWardByDistrictCode(Request $request) {
        return $this->locationRepository->getByWardByDistrictCode($request['districtCode']);
    }


    public function address(Request $request) {
        return $this->locationRepository->getAddress($request['wardCode']);
    }



}
