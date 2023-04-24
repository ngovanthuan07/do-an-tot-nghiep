<?php

namespace App\Repositories;

use App\Helpers\ImageHelper;
use App\Models\Salon;
use App\Models\Service;
use http\Env\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ServiceRepository
{
    public function create($request) {
        $service = new Service();
        $service->name = $request->input('name');
        $service->price = $request->input('price');
        $service->description = $request->input('description');
        $service->image = ImageHelper::saveImage('service', $request->file('file'));
        $service->status = 'ON';
        $service->cse_id = $request->input('cse_id');
        $service->salon_id = Auth::guard('salon')->user()->salon_id;
        $service->save();
        return $service ?? null;
    }

    public function getAllServiceBySalonId($salonId) {
        return DB::table('service')
            ->join('categoryservice', 'service.cse_id', '=', 'categoryservice.cse_id')
            ->join('salon', 'salon.salon_id', '=', 'service.salon_id')
            ->select('service.*', 'categoryservice.name as category_service_name')
            ->where('service.status', 'ON')
            ->where('service.salon_id', $salonId)
            ->get();
        ;
    }

    public function getServiceByIdServiceAndSalon($idService, $idSalon) {
        $service = Service::query()
            ->where('service_id', $idService)
            ->where('salon_id', $idSalon)
            ->first();
        return $service;
    }

    public function update($request, $idSalon) {
        $service = Service::query()
            ->where('service_id', $request->service_id)
            ->where('salon_id', $idSalon)
            ->first();

        $service->name = $request->input('name');
        $service->price = $request->input('price');
        $service->description = $request->input('description');
        if($request->file('file')) {
            ImageHelper::deleteImage('service', $service->image);
            $service->image = ImageHelper::saveImage('service', $request->file('file'));
        }
        $service->cse_id = $request->input('cse_id');
        $service->salon_id = Auth::guard('salon')->user()->salon_id;
        $service->update();
        return $service ?? null;
    }

    public function updateStatus($request, $idService) {
        $service = Service::query()
            ->where('service_id', $idService)
            ->where('salon_id', Auth::guard('salon')->user()->salon_id)
            ->first();

        $service->status = $request->input('status');
        $service->update();
        return $service ?? null;
    }
}
