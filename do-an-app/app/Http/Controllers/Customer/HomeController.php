<?php

namespace App\Http\Controllers\Customer;

use App\DTO\OutstandingDTO;
use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index() {
        $outstanding = OutstandingDTO::convertHome(DB::select('CALL GetSalonByStatusAndOutstanding()'));
        $salonDaNang = OutstandingDTO::convertHome(DB::select('CALL GetSalonDaNang()'));
        $top10SalonDaNang = OutstandingDTO::convertHome(DB::select('CALL GetTop10SalonDaNang()'));
        $posts = Post::query()->orderBy('post_id', 'desc')->get();
        return view('components.customer.home.home-page', compact('outstanding', 'salonDaNang', 'top10SalonDaNang', 'posts'));
    }
}
