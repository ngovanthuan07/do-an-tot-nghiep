<?php

namespace App\Http\Controllers\Salon;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function lComment()
    {
        return view("components.salon.comment.index");
    }

    public function commentApi()
    {
        $comments = Comment::query()->where('salon_id', Auth::guard('salon')->user()->salon_id)->orderByDesc('comment_id')->get();
        foreach ($comments as $comment) {
            if($comment != null) {
                $comment->customer = Customer::query()->where('customer_id', $comment->customer_id)->first();
            }
        }
        return $comments;
    }

    public function commentDelete(Request $request) {
        $commentId = $request['comment_id'];
        Comment::destroy($commentId);

        return redirect()->route('salon.comment.lComment');
    }
}
