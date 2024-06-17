<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Services\CategoryService;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    const CATEGORIES_PATH = '/categories';

    public function __construct() {
        $this->middleware('permission:create-category')->only('store', 'create');
        $this->middleware('permission:edit-category')->only('update', 'edit');
        $this->middleware('permission:delete-category')->only('destroy');
        $this->middleware('permission:view-category')->only('index');
    }

    public function index() {
        $categories = Category::with('children')->whereNull('parent_id')->get();
        return view('categories.index', ['categories' => $categories]);
    }

    public function create() {
        $categories = Category::with('children')->whereNull('parent_id')->get();
        return view('categories.create_edit', ['categories' => $categories]);
    }
    public function store(Request $request) {
        $description = $request->input('description');
        $description = substr($description, 3, strlen($description) - 7);

        $parent_id = $request->input('parent_id');

        $request->validate([
            'title' => 'required|unique:categories|max:20',
        ]);

        DB::table('categories')->insert([
            'title' => $request->get('title'),
            'description' => $description,
            'parent_id' => $parent_id,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        return redirect(CategoryController::CATEGORIES_PATH);
    }

    public function show($id) {
        $category = DB::table('categories')->where('id', $id)->first();
        return view('categories.show', ['category' => $category]);
    }
    public function edit($id) {
        $category = DB::table('categories')->where('id', $id)->first();
        $categories = Category::with('children')->whereNull('parent_id')->get();
        return view('categories.create_edit', ['c' => $category, 'categories' => $categories]);
    }
    public function update(Request $request, $id) {
        $description = $request->input('description');
        $description = substr($description, 3, strlen($description) - 7);

        DB::table('categories')->where('id', $id)->update([
            'title' => $request->get('title'),
            'description' => $description,
            'parent_id' => $request->get('parent_id'),
            'updated_at' => now(),
        ]);
        return redirect(self::CATEGORIES_PATH);
    }

    public function destroy($id) {
        $categories = Category::where('id', $id)->with('children')->delete();
//        dd($categories);
        return redirect(self::CATEGORIES_PATH);
    }
}
