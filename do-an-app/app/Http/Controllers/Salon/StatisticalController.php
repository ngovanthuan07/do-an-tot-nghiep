<?php

namespace App\Http\Controllers\Salon;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class StatisticalController extends Controller
{

    public function top_nhan_vien()
    {
        return view('components.salon.statistic.employee_date_year');
    }
    public function top_nhan_vien_api(Request $request)
    {
        $salonID = Auth::guard('salon')->user()->salon_id;
        $month = $request['month'] ?? 0;
        $year = $request['year'] ?? 0;

        return DB::select('CALL TopEmployeeBySalonBookFollowingMonthOrYear(?,?,?)', [$salonID, $month, $year]);
    }
}
