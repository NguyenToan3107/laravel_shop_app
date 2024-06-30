<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProductSkusController extends Controller
{
    public function create() {
        return view('admin.products.product_skus.create');
    }

    public function store(Request $request, $product_id) {
        dd($product_id);
    }
}
