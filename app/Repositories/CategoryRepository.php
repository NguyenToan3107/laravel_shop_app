<?php
namespace App\Repositories;
use App\Models\Category;
use Illuminate\Support\Facades\DB;
class CategoryRepository implements CategoryRepositoryInterface
{

    public function getAll()
    {
        return Category::all();
    }

    public function getById($id)
    {
        return DB::table('categories')->where('id', $id)->first();
    }

    public function createCategory($data)
    {
        return DB::table('categories')->insert($data);
    }

    public function updateCategory($id, $data)
    {
        return DB::table('categories')->where('id', $id)->update($data);
    }

    public function deleteCategory($id)
    {
        return DB::table('categories')->where('id', $id)->delete();
    }
}
