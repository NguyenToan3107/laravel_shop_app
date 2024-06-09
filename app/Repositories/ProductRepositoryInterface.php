<?php
namespace App\Repositories;
interface ProductRepositoryInterface {
    public function getAll();
    public function getById($id);
    public function createProduct($data);
    public function updateProduct($id, $data);
    public function deleteProduct($id);
}
