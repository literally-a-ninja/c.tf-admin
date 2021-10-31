<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use App\Models\Post;

class PostsController extends AppBaseController
{
    public function index () : View|Factory|Application
    {
        /** @var Post $posts */
        $posts = Post::all();
        return view ('posts.index')
            ->with('posts', $posts);
    }

    /**
     * Show the form for creating a new post.
     *
     * @return Response
     */
    public function create()
    {
        return view('posts.create');
    }
}