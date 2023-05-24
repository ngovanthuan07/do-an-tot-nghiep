<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\ImageHelper;
use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function index() {
        return view('components.admin.post.index');
    }
    public function listPostApi() {
        return Post::all();
    }
    public function showAdd()
    {
        return view('components.admin.post.add');
    }

    public function showUpdate(Request $request)
    {
        $post = Post::find($request['post_id']);
        return view('components.admin.post.update', compact('post'));
    }

    public function save(Request $request)
    {
        $post = new Post();
        $post->title = $request->input('title');
        $post->image = ImageHelper::saveImage('post', $request->file('file'));
        $post->content = $request->input('content');
        $post->admin_id = Auth::guard('admin')->user()->admin_id;
        $post->save();

        return response()->json([
           'success' => true
        ]);
    }

    public function update(Request $request) {
        $post = Post::find($request->input('post_id'));
        $post->title = $request->input('title');
        if($request->file('file')) {
            ImageHelper::deleteImage('post', $post->image);
            $post->image = ImageHelper::saveImage('post', $request->file('file'));
        }
        $post->content = $request->input('content');
        $post->admin_id = Auth::guard('admin')->user()->admin_id;
        $post->update();
        return response()->json([
            'success' => true
        ]);
    }

    public static function delete(Request $request)
    {
        $post = Post::find($request['post_id']);
        $post->delete();

        return response()->json([
            'success' => true
        ]);
    }
}
