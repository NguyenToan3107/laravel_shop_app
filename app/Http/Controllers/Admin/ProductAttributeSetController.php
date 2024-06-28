<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class ProductAttributeSetController extends Controller
{
    public function index() {
        return view('admin.products.product_attribute_sets.index');
    }
    public function create() {}
    public function store() {}
    public function edit() {}
    public function update() {}
    public function destroy() {}
}
