<?php
namespace App\Services;
use App\Repositories\CategoryRepository;

class CategoryService {
    public function __construct(protected CategoryRepository $categoryRepository)
    {

    }
    public function getCategories() {
        return $this->categoryRepository->getAll();
    }
    public function getCategoryById($id) {
        return $this->categoryRepository->getById($id);
    }
    public function createCategory($data) {
        return $this->categoryRepository->createCategory($data);
    }
    public function updateCategory($id, $data) {
        return $this->categoryRepository->updateCategory($id, $data);
    }
    public function deleteCategory($id) {
        return $this->categoryRepository->deleteCategory($id);
    }
}
