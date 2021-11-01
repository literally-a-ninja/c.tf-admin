<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use App\Models\Post;

use Flash;

class PostsController extends AppBaseController
{
    public function index () : View|Factory|Application
    {
        /** @var Post $posts */
        $posts = Post::all();
        return view ('posts.index')
            ->with('posts', $posts);
    }

    public function show($id) {
        /** @var Post $post */
        $post = Post::find($id);
        if(empty($post)) {
            Flash::error("Post not found");
            return redirect(route("posts.index"));
        }
        return view('posts.show')->with('post',$post);
        

    }
}