<?php

namespace App\Http\Controllers\Customer;

use App\Helpers\HandleDateTimePickerHelper;
use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function addComment(Request $request) {
        $comment = new Comment();
        $comment->star = $request->input("star");
        $comment->date = HandleDateTimePickerHelper::getToday();
        $comment->content = $request->input("content");
        $comment->customer_id = Auth::guard('customer')->user()->customer_id;
        $comment->salon_id = $request->input('salon_id');
        $comment->save();

        return response()->json([
            'success' => true
        ]);
    }
}
