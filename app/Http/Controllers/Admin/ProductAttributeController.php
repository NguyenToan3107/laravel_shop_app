<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProductAttributeController extends Controller
{
    public function index() {
        return view('admin.products.product_attributes.index');
    }
    public function create() {
        return view('admin.products.product_attributes.create');
    }

    public function store(Request $request)
    {

    }

    public function edit($id) {
        return view('admin.products.product_attributes.edit');
    }

    public function update($id) {}
    public function destroy($id) {}

}
