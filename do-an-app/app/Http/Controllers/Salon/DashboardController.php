<?php

namespace App\Http\Controllers\Salon;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index() {
        return view('components.salon.dashboard');
    }
}
