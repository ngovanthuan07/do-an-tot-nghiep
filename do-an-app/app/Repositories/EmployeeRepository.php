<?php

namespace App\Repositories;

use App\Helpers\ImageHelper;
use App\Models\Employee;
use App\Models\Salon;
use App\Models\Service;
use http\Env\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class EmployeeRepository
{
    public function getAllBySalonID($salonId)
    {
        return Employee::query()
            ->where('salon_id', $salonId)
            ->where('status', 'active')
            ->get();
    }

    public function getEmployeeByEmployeeIDAndSalonID($employeeId, $salonId)
    {
        return Employee::query()
            ->where('employee_id', $employeeId)
            ->where('salon_id', $salonId)
            ->where('status', 'active')
            ->first();
    }
    public function create($request) {
        $employee = new Employee();
        $employee->fullname = $request->input('fullname');
        $employee->phone = $request->input('phone');
        $employee->dob = $request->input('dob');
        $employee->cic = $request->input('cic');
        $employee->gender = $request->input('gender');
        $employee->description = $request->input('description');
        $employee->status = $request->input('status');
        $employee->salon_id = Auth::guard('salon')->user()->salon_id;
        $employee->image = ImageHelper::saveImage('employee', $request->file('file'));

        $employee->save();

        return $employee;
    }

    public function update($request,$employeeId) {
        $employee = $this->getEmployeeByEmployeeIDAndSalonID(
            $employeeId, Auth::guard('salon')->user()->salon_id);

        $employee->fullname = $request->input('fullname');
        $employee->phone = $request->input('phone');
        $employee->dob = $request->input('dob');
        $employee->cic = $request->input('cic');
        $employee->gender = $request->input('gender');
        $employee->description = $request->input('description');
        $employee->status = $request->input('status');

        if($request->file('file')) {
            ImageHelper::deleteImage('employee', $employee->image);
            $employee->image = ImageHelper::saveImage('employee', $request->file('file'));
        }

        $employee->update();

        return $employee;
    }


    public function updateStatus($request,$employeeId) {
        $employee = $this->getEmployeeByEmployeeIDAndSalonID(
            $employeeId, Auth::guard('salon')->user()->salon_id);

        $employee->status = $request->input('status');

        $employee->update();

        return $employee;
    }

}
