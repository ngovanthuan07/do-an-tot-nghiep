<?php

namespace App\Repositories;

use App\Models\Salon;
use http\Env\Request;
use Illuminate\Support\Facades\Hash;

class SalonRepository
{
    public function adminSaveSalon($request) {
        $salon = new Salon();
        $salon->name = $request->input('name');
        $salon->username = $request->input('username');
        $salon->password = Hash::make($request->input('password'));
        $salon->phone = $request->input('phone');
        $salon->address = $request->input('address');
        $salon->description = $request->input('description');
        $salon->role = 'ROLE_SALON';
        $salon->status = 'ON';
        $salon->ward_code = $request->input('ward');
        $salon->save();
        return $salon;
    }

    public function adminUpdateSalon($request) {
        $salon = Salon::query()->where('salon_id', $request->input('salon_id'))->first();
        $salon->name = $request->input('name');
        $salon->username = $request->input('username');
        if(isset($salon->password))
        {
            $salon->password = Hash::make($request->input('password'));
        }
        $salon->phone = $request->input('phone');
        $salon->address = $request->input('address');
        $salon->description = $request->input('description');
        $salon->ward_code = $request->input('ward');
        $salon->save();
        return $salon;
    }

    public function getAllSalonStatusOn() {
        return Salon::query()->where('status', 'ON')->get();
    }

    public function getAllSalonStatusBlock() {
        return Salon::query()->where('status', 'BLOCK')->get();
    }

    public function salonStatus($request) {
        try {
            $status = $request->input('status');
            $salon = Salon::query()->where('salon_id', $request->input('salonId'))->first();
            $salon->status = $status;
            $salon->update();
            return true;
        } catch (\Exception $exception) {
            return false;
        }
    }

    public function getSalonById($salonId) {
       $salon = Salon::query()->where('salon_id', $salonId)->first();
       return $salon ?? null;
    }

    public function saveImage($images, $idSalon) {
        $salon = Salon::query()
            ->where('salon_id', $idSalon)
            ->first();
        $salon->images = $images;

        $salon->update();

        return $salon;
    }

    public function updateTimeDesc($idSalon, $timeWorkDESC, $timeSlotDESC) {
        $salon = Salon::query()
            ->where('salon_id', $idSalon)
            ->first();
        $salon->time_working_desc = $timeWorkDESC;
        $salon->time_slot_desc = $timeSlotDESC;
        $salon->update();
        return $salon;
    }
}
