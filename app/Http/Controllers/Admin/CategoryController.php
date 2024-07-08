<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    const CATEGORIES_PATH = '/admin/categories';

    public function __construct()
    {
        $this->middleware('permission:create-category')->only('store', 'create');
        $this->middleware('permission:edit-category')->only('update', 'edit');
        $this->middleware('permission:delete-category')->only('destroy');
        $this->middleware('permission:view-category')->only('index');
    }

    public function index()
    {
        $categories = Category::with('children')->whereNull('parent_id')->get();
        return view('admin.categories.index', ['categories' => $categories]);
    }
    public function create()
    {
        $categories = Category::with('children')->whereNull('parent_id')->get();
        return view('admin.categories.create_edit', ['categories' => $categories]);
    }

    public function store(Request $request)
    {
        $description = $request->input('description');
        $description = substr($description, 3, strlen($description) - 7);

        $parent_id = $request->input('parent_id');

        $request->validate([
            'title' => 'required|unique:categories|max:20',
        ]);

        if($request->filled('filepath')) {
            $image_path = $request->input('filepath');
            $image_path = explode('http://localhost:8000', $image_path)[1];
        }else {
            $image_path = '/storage/photos/products/empty-photo.jpg';
        }

        Category::create([
            'title' => $request->get('title'),
            'description' => $description,
            'parent_id' => $parent_id,
            'image' => $image_path,
        ]);
        return redirect(CategoryController::CATEGORIES_PATH);
    }

    public function edit($slug)
    {
        $category = Category::where('slug', $slug)->first();
        if($category->parent_id !== null){
            $parent_category = Category::where('id', $category->parent_id)->first();
        }
        else {
            $parent_category = $category;
        }
        $categories = Category::with('children')->whereNull('parent_id')->get();
        return view('admin.categories.create_edit',
            [
                'c' => $category,
                'categories' => $categories,
                'parent_category' => $parent_category
            ]);
    }

    public function update(Request $request, $slug)
    {
        $category = Category::where('slug', $slug)->first();
        $description = $request->input('description');

        if($request->filled('filepath')) {
            $image_path = $request->input('filepath');
            $image_path = explode('http://localhost:8000', $image_path)[1];
        }else {
            $image_path = $category->image;
        }

        $category->update([
            'title' => $request->get('title'),
            'description' => $description,
            'parent_id' => $request->get('parent_id'),
            'image' => $image_path,
            'updated_at' => now(),
        ]);
        return redirect(self::CATEGORIES_PATH);
    }

    public function destroy($slug)
    {
        Category::where('slug', $slug)->with('children')->delete();
        return redirect(self::CATEGORIES_PATH);
    }
}
