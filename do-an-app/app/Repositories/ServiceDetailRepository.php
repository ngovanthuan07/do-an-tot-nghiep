<?php

namespace App\Repositories;

use App\Models\Salon;
use App\Models\ServiceDetail;
use http\Env\Request;
use Illuminate\Support\Facades\Hash;

class ServiceDetailRepository
{
    public function saveListObjectServiceAndAppointment($services, $appointmentId) {
        foreach ($services as $service) {
            ServiceDetail::create([
                'service_id' => $service->service_id,
                'appointment_id' => $appointmentId,
                'status' => 'active'
            ]);
        }
    }
}
