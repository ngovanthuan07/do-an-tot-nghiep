<?php

namespace App\Http\Controllers\Salon;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Comment;
use App\Models\Customer;
use App\Models\Employee;
use App\Models\PaymentService;
use App\Models\Salon;
use App\Models\Service;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class StatisticalController extends Controller
{
    public function all() {
        $salonID = Auth::guard('salon')->user()->salon_id;
        $revenueQuery = DB::table('appointment as a')
            ->select(DB::raw('SUM(ps.total) as total'))
            ->join('paymentservice as ps', 'a.appointment_id', '=', 'ps.appointment_id')
            ->join('salon as s', 'a.salon_id', '=', 's.salon_id')
            ->where('a.status', Appointment::$COMPLETED)
            ->where('s.salon_id', $salonID)
            ->groupBy('s.salon_id')
            ->first();

        $resultStar = DB::select('CALL GetTotalStarBySalonID(?)', [$salonID]);

        $star = $resultStar[0]->average_stars ?? 0;

        $commentCount = Comment::where('salon_id', $salonID)->count();


        $revenue = $revenueQuery ? $revenueQuery->total : 0;
        $countAppointmentSuccess = Appointment::query()
            ->where('salon_id', $salonID)
            ->where('status', Appointment::$COMPLETED)
            ->count();
        $countService = Service::query()
            ->where('salon_id', $salonID)
            ->where('status', 'active')
            ->count();
        $countEmployee = Employee::query()
            ->where('salon_id', $salonID)
            ->where('status', 'active')
            ->count();
        return view('components.salon.statistic.index',
            compact('salonID','revenue','countAppointmentSuccess','countService','countEmployee', 'star', 'commentCount')
        );
    }

    public function topEmployeeMonthAndYear(Request $request) {
        $month = $request['month'];
        $year = $request['year'];
        $type = $request['type'];
        $salonID = Auth::guard('salon')->user()->salon_id;

        $topEmployee = DB::table('appointment AS a')
            ->select('a.customer_id', 'c.fullname', 'c.image', 'c.phone', 'c.email', DB::raw('SUM(ps.total) as total'), DB::raw('COUNT(a.customer_id) AS count'))
            ->join('salon AS s', 'a.salon_id', '=', 's.salon_id')
            ->join('customer AS c', 'a.customer_id', '=', 'c.customer_id')
            ->join('paymentservice as ps', 'a.appointment_id', '=', 'ps.appointment_id')
            ->where('a.salon_id', $salonID)
            ->where('a.status', 'completed')
            ->where(function ($query) use ($month, $year, $type) {
                if($type == 'my') {
                    $query->whereRaw('MONTH(a.appointment_date) = ?', [$month]);
                    $query->whereRaw('YEAR(a.appointment_date) = ?', [$year]);
                } else if($type == 'y') {
                    $query->whereRaw('YEAR(a.appointment_date) = ?', [$year]);
                }
            })
            ->groupBy('a.customer_id')
            ->orderByDesc(DB::raw('SUM(a.customer_id)'), DB::raw('COUNT(a.customer_id)'))
            ->limit(10)->get();

        return $topEmployee;
    }

    public function getRevenueAndBookByMonth(Request $request)
    {
        $salonID = Auth::guard('salon')->user()->salon_id;
        $revenues = [];
        $books = [];
        try {
            $revenues = DB::select('CALL GetRevenueByMonth(?, ?)', [$request['year'], $salonID]);
            $books = DB::select('CALL GetBookCompleteByMonth(?, ?)', [$request['year'], $salonID]);
            return response()->json(
                compact('revenues', 'books')
            );
        } catch (\Exception $e) {
            return response()->json(
                compact('revenues', 'books')
            );
        }
    }

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
