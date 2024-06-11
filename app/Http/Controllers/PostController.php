<?php

namespace App\Http\Controllers;

use App\DataTables\PostsDataTable;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class PostController extends Controller
{

    const POSTS_PATH = '/posts';

    public function index(PostsDataTable $dataTable_post) {
        return $dataTable_post->render('posts.index');
    }
    public function create() {
        $users = User::query()
            ->select(['id', 'name'])
            ->orderBy('name')
            ->get();
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
        $post = DB::table('posts')
            ->select(['id', 'title', 'image', 'description', 'content', 'author_id', 'status', 'created_at', 'updated_at'])
            ->where('id', $id)
            ->first();
        $users = User::query()
            ->select(['id', 'name'])
            ->orderBy('name')
            ->get();

        $user = DB::table('users')->select(['id', 'name'])->where('id', $post->author_id)->first();

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
    public function destroy($id, Request $request)
    {
        if($request->filled('id')) {
            DB::table('posts')->where('id', $id)->delete();
        }
        $model = Post::query()
            ->select(['id', 'image', 'title', 'description', 'author_id', 'status', 'created_at', 'updated_at'])
            ->where('deleted_at','<>', 'null')
            ->where('status', 4);

        return DataTables::of($model)
            ->editColumn('status', function ($product) {
                if ($product->status == 1) {
                    return 'Hoạt động';
                } elseif ($product->status == 2) {
                    return 'Không hoạt động';
                } elseif ($product->status == 3) {
                    return 'Đợi';
                } else {
                    return 'Xóa mềm';
                }
            })
            ->editColumn('price', function ($product) {
                return number_format($product->price * 1000, 0, ',', ',');
            })
            ->addColumn('action', function ($product) {
                return view('products.action_delete', ['product' => $product]);
            })
            ->editColumn('image', function ($row) {
                return '<img class="img-thumbnail user-image-45" src="/images/products/' . $row->image . '" alt="' . $row->title . '">';
            })
            ->rawColumns(['image'])
            ->make();
    }

    // soft post
    public function softDelete(Request $request)
    {
        $model = Post::query()
            ->select(['id', 'image', 'title', 'description', 'author_id', 'status', 'created_at', 'updated_at'])
            ->whereNull('deleted_at')
            ->where('status', '<>', 4);
        if ($request->filled('post_id')) {
            Post::find($request->post_id)->update([
                'deleted_at' => now(),
                'status' => 4
            ]);
        }
        return DataTables::of($model)
            ->editColumn('status', function ($post) {
                $statusMessages = [
                    1 => 'Hoạt động',
                    2 => 'Không hoạt động',
                    3 => 'Đợi',
                    4 => 'Xóa mềm'
                ];
                return $statusMessages[$post->status];
            })
            ->addColumn('action', function ($post) use ($request) {
                if ($request->filled('status')) {
                    if ($post->status == 4) {
                        return view('posts.action_delete', ['post' => $post]);
                    }
                    return view('posts.action', ['post' => $post]);
                }
            })
            ->editColumn('author_id',function ($post) {
                return $post->users->name;
            })
            ->editColumn('image', function ($row) {
                return '<img class="img-thumbnail user-image-45" src="/images/posts/' . $row->image . '" alt="' . $row->title . '">';
            })
            ->rawColumns(['image'])
            ->make();
    }
}
