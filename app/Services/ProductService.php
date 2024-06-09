<?php

namespace App\Services;

use App\Repositories\ProductRepository;

class ProductService
{
    public function __construct(protected ProductRepository $productRepository)
    {

    }
    public function getProducts() {
        return $this->productRepository->getAll();
    }
    public function getProductById($id) {
        return $this->productRepository->getById($id);
    }
    public function createProduct($data) {
        return $this->productRepository->createProduct($data);
    }
    public function updateProduct($id, $data) {
        return $this->productRepository->updateProduct($id, $data);
    }
    public function deleteProduct($id) {
        return $this->productRepository->deleteProduct($id);
    }
}
