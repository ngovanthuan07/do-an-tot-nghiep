<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function post(Request $request) {
        $post = Post::find($request['post_id']);

        return view('components.customer.post.my-post', compact('post'));
    }
}
