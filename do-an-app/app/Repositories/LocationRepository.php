<?php

namespace App\Repositories;

use http\Env\Request;
use Illuminate\Support\Facades\DB;

class LocationRepository
{
    public function getAllProvince() {
        return DB::table('provinces')->get();
    }

    public function getProvinceByCode($code) {
        return DB::table('provinces')->where('code', $code)->first();
    }

    public function getByDistrictByProvinceCode($provinceCode) {
        return DB::table('districts')->where('province_code', $provinceCode)->get();
    }

    public function getByWardByDistrictCode($districtCode) {
        return DB::table('wards')->where('district_code', $districtCode)->get();
    }


    public function getAddress($wardCode) {
        $ward = DB::table('wards')->where('code', $wardCode)->first();
        $district = DB::table('districts')->where('code', $ward->district_code)->first();
        $provinces = DB::table('provinces')->where('code', $district->province_code)->first();

        $address = $ward->full_name . ', ' . $district->full_name . ', ' . $provinces->full_name;
        return [
          'province' => $provinces,
          'district' => $district,
          'ward' => $ward,
          'address' => $address
        ];
    }


}
