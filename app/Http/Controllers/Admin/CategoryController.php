<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\CategoriesDataTable;
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

//    public function index(CategoriesDataTable $dataTable) {
//
////        $categories = Category::with('children')->whereNull('parent_id')->get();
//        return $dataTable->render('admin.categories.index');
//    }

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

        DB::table('categories')->insert([
            'title' => $request->get('title'),
            'description' => $description,
            'parent_id' => $parent_id,
            'image' => $image_path,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        return redirect(CategoryController::CATEGORIES_PATH);
    }

    public function show($id)
    {
        $category = DB::table('categories')->where('id', $id)->first();
        return view('admin.categories.show', ['category' => $category]);
    }

    public function edit($id)
    {
        $category = DB::table('categories')->where('id', $id)->first();
        if($category->parent_id !== null){
            $parent_category = DB::table('categories')->where('id', $category->parent_id)->first();
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

    public function update(Request $request, $id)
    {
        $category = Category::find($id);
        $description = $request->input('description');
//        $description = substr($description, 3, strlen($description) - 7);

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

    public function destroy($id)
    {
        Category::where('id', $id)->with('children')->delete();
        return redirect(self::CATEGORIES_PATH);
    }
}
