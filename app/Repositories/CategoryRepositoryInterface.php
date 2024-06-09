<?php

namespace App\Repositories;
interface CategoryRepositoryInterface
{
    public function getAll();
    public function getById($id);
    public function createCategory($data);
    public function updateCategory($id, $data);
    public function deleteCategory($id);
}
