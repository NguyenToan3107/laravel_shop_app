<?php

namespace App\Http\Controllers;

use App\DataTables\PostsDataTable;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PostController extends Controller
{

    const POSTS_PATH = '/posts';

    public function index(PostsDataTable $dataTable_post) {
        return $dataTable_post->render('posts.index');
    }
    public function create() {
        $users = User::all();
        return view('posts.create_edit', [
            'users' => $users
        ]);
    }
    public function store(Request $request)
    {
        $description = $request->input('description');
        $description = substr($description, 3, strlen($description) - 7);

        $content = $request->input('content');
        $content = substr($content, 3, strlen($content) - 7);

        $request->validate([
//            'product_image' => 'required|image|mimes:jpeg,png,jpg|max:5048',
//            'title' => 'required|unique:products',
        ]);

        if(isset(request()->image)) {
            $generatedImageName = str_replace(' ', '',
                ('image' . time() . '-'.request()->name. '.' .request()->image->getClientOriginalExtension()));
            request()->image->move(public_path('images/posts'), $generatedImageName);
        } else {
            $generatedImageName = 'default_post.png';
        }

        DB::table('posts')->insert([
            'title' => $request->input('title'),
            'description' => $description,
            'content' => $content,
            'image' => $generatedImageName,
            'author_id' => $request->input('author_id'),
            'status' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect(PostController::POSTS_PATH);
    }
    public function show($id) {

    }
    public function edit($id) {
        $post = Post::find($id);
        $users = User::all();
        $user = $post->users;

        return view('posts.create_edit', [
            'post' => $post,
            'users' => $users,
            'user' => $user
        ]);
    }
    public function update(Request $request, $id) {
        $description = $request->input('description');
        $description = substr($description, 3, strlen($description) - 7);

        $content = $request->input('content');
        $content = substr($content, 3, strlen($content) - 7);

        $post = DB::table('posts')->find($id);

        if(isset(request()->image)) {
            $generatedImageName = str_replace(' ', '',
                ('image' . time() . '-'.request()->name. '.' .request()->image->getClientOriginalExtension()));
            request()->image->move(public_path('images/posts'), $generatedImageName);
        } else {
            $generatedImageName = $post->image;
        }

        DB::table('posts')->where('id', $id)->update([
            'title' => $request->input('title'),
            'description' => $description,
            'content' => $content,
            'image' => $generatedImageName,
            'author_id' => $request->input('author_id'),
            'status' => $request->input('status'),
            'updated_at' => now(),
        ]);

        return redirect(PostController::POSTS_PATH);
    }
    public function destroy($id) {

    }
}
