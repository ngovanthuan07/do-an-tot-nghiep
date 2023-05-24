<?php

namespace App\Http\Controllers\Admin\Setting;

use App\Http\Controllers\Controller;
use App\Models\Outstanding;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OutstandingController extends Controller
{
    public function index()
    {
        return view('components.admin.settings.outstanding.index');
    }

    public function listSalonNotOutstanding() {
        return DB::select('CALL GetSalonByStatusAndNotInOutstanding()');
    }
    public function listSalonOutstanding() {
        return DB::select('CALL GetSalonByStatusAndOutstanding()');
    }
    public function addOutstanding(Request $request) {
        $salonID = $request['salon_id'];
        $outstanding = new Outstanding();

        $outstanding->admin_id = Auth::guard('admin')->user()->admin_id;
        $outstanding->salon_id = $salonID;

        $outstanding->save();

        return response()->json(
            [
                'success' => true
            ]
        );
    }

    public function removeOutstanding(Request $request)
    {
        $salonID = $request['salon_id'];

        $outstanding = Outstanding::where('salon_id', $salonID)->first();
        $outstanding->delete();
        return response()->json([
            'success' => true
        ]);
    }
}
