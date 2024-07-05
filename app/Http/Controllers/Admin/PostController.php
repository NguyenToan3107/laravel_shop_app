<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\PostsDataTable;
use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class PostController extends Controller
{
    const POSTS_PATH = '/admin/posts';

    public function __construct() {
        $this->middleware('permission:create-post')->only('store', 'create');
        $this->middleware('permission:edit-post')->only('update', 'edit');
        $this->middleware('permission:delete-post')->only('destroy', 'softDelete');
        $this->middleware('permission:view-post')->only('index');
    }

    public function index(PostsDataTable $dataTable_post) {
        return $dataTable_post->render('admin.posts.index');
    }
    public function create() {
        $users = User::query()
            ->select(['id', 'name'])
            ->orderBy('name')
            ->get();

        $permissionName = 'create-post';

        // get all user has create-post permission
        $usersWithPermission = $users->filter(function ($user) use ($permissionName) {
            return $user->hasPermissionTo($permissionName);
        });

        return view('admin.posts.create_edit', [
            'users' => $usersWithPermission
        ]);
    }
    public function store(Request $request)
    {
        if($request->filled('filepath')) {
            $image_path = $request->input('filepath');
            $image_path = explode('http://localhost:8000', $image_path)[1];
        }else {
            $image_path = '/storage/photos/posts/default_post.png';
        }
        $description = $request->input('description');
        $content = $request->input('content');

        $request->validate([
//            'product_image' => 'required|image|mimes:jpeg,png,jpg|max:5048',
//            'title' => 'required|unique:products',
        ]);

        Post::create([
            'title' => $request->input('title'),
            'description' => $description,
            'content' => $content,
            'image' => $image_path,
            'author_id' => $request->input('author_id'),
            'status' => 1,
        ]);

        return redirect(PostController::POSTS_PATH);
    }

    public function edit($slug) {
        $post = Post::select(['id', 'title', 'image', 'description', 'content', 'author_id', 'status', 'created_at', 'updated_at', 'slug'])
            ->where('slug', $slug)
            ->first();
        $users = User::query()
            ->select(['id', 'name'])
            ->orderBy('name')
            ->get();

        $user = User::select(['id', 'name'])->where('id', $post->author_id)->first();

        return view('admin.posts.create_edit', [
            'post' => $post,
            'users' => $users,
            'user' => $user
        ]);
    }
    public function update(Request $request, $slug) {

        $description = $request->input('description');

        $content = $request->input('content');

        $post = Post::find($slug);

        if($request->filled('filepath')) {
            $image_path = $request->input('filepath');
            $image_path = explode('http://localhost:8000', $image_path)[1];
        }else {
            $image_path = $post->image;
        }

        $post->update([
            'title' => $request->input('title'),
            'description' => $description,
            'content' => $content,
            'image' => $image_path,
            'author_id' => $request->input('author_id'),
            'status' => $request->input('status'),
            'updated_at' => now(),
            'deleted_at' => null
        ]);

        return redirect(PostController::POSTS_PATH);
    }
    public function destroy($id, Request $request)
    {
        if($request->filled('id')) {
            Post::where('id', $id)->delete();
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
            ->editColumn('author_id',function ($post) {
                return $post->users->name;
            })
            ->addColumn('action', function ($post) {
                return view('admin.posts.action_delete', ['post' => $post]);
            })
            ->editColumn('image', function ($row) {
                return '<img class="img-thumbnail user-image-45" src="' . $row->image . '" alt="' . $row->title . '">';
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
                }else {
                    return view('posts.action', ['post' => $post]);
                }
            })
            ->editColumn('author_id',function ($post) {
                return $post->users->name;
            })
            ->editColumn('image', function ($row) {
                return '<img class="img-thumbnail user-image-45" src="' . $row->image . '" alt="' . $row->title . '">';
            })
            ->rawColumns(['image'])
            ->make();
    }
}
