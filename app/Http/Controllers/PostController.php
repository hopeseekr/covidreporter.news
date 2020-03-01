<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class PostController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|View
     */
    public function index(Request $request)
    {
        if (Auth::check() && Auth::user()->password_changed_at === null) {
            return redirect(route('users.password'));
        }

        return view('posts.index', [
            'posts' => Post::search($request->input('q'))
                             ->with('author', 'likes')
                             ->withCount('comments', 'thumbnail', 'likes')
                             ->latest()
                             ->paginate(20)
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Post $post): View
    {
        $post->comments_count = $post->comments()->count();
        $post->likes_count = $post->likes()->count();

        return view('posts.show', [
            'post' => $post
        ]);
    }
}
