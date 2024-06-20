<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;

class ProductDetailController extends Controller
{
    public function index() {
        return view('frontend.product_detail.index');
    }
}
