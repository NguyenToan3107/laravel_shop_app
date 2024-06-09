<?php

namespace App\Repositories;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class ProductRepository implements ProductRepositoryInterface {

    public function getAll()
    {
        return DB::table('products')->get();
    }

    public function getById($id)
    {
        return DB::table('products')->where('id', $id)->first();
    }

    public function createProduct($data)
    {
        return DB::table('products')->insert($data);
    }

    public function updateProduct($id, $data)
    {
        return DB::table('products')->where('id', $id)->update($data);
    }

    public function deleteProduct($id)
    {
        return DB::table('products')->where('id', $id)->delete();
    }
}
