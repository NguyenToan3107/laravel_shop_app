<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::select('title', 'id', 'slug', 'description', 'content', 'image', 'author_id', 'created_at', 'slug')->get();

        return view('frontend.posts.index', [
            'posts' => $posts
        ]);
    }

    public function show($slug) {
        $post = Post::where('slug', $slug)->firstOrFail();

        $involve_posts = Post::select('title', 'id', 'slug', 'description', 'content', 'image', 'author_id', 'created_at', 'slug')
            ->take(5)
            ->inRandomOrder()
            ->where('slug', '!=', $post->slug)
            ->get();

        return view('frontend.posts.show', [
            'post' => $post,
            'involve_posts' => $involve_posts
        ]);
    }
}
