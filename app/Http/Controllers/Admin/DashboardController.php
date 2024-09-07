<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $count_users = User::count();
        $count_posts = Post::count();
        $count_products = Product::count();
        $count_categories = Category::count();
        $yearNow = Carbon::now()->year;

        $categories = Category::with('children')
            ->select(['title', 'parent_id', 'id', 'total_order'])
            ->where('parent_id', null)
            ->get();

        // tinh so luong theo san pham => tinh duoc tong san pham theo danh muc
        $totalOrderCategories = [];
        foreach ($categories as $rootCategory) {
            $totalOrder = $this->calculateTotalOrder($rootCategory);
            $totalOrderCategories[$rootCategory->title] = $totalOrder;
        }



        $dataBar_Revenue = [
            'labels' => array_keys($totalOrderCategories),
            'datasets' => [
                [
                    'label' => 'Doanh thu',
                    'backgroundColor' => [
                        '#3498db', '#2ecc71', '#e74c3c', '#f1c40f', '#9b59b6', '#2980b9', '#27ae60', '#c0392b', '#f39c12', '#8e44ad'
                    ],
                    'borderColor' => [
                        '#3498db', '#2ecc71', '#e74c3c', '#f1c40f', '#9b59b6', '#2980b9', '#27ae60', '#c0392b', '#f39c12', '#8e44ad'
                    ],
                    'data' => array_values($totalOrderCategories),
                ],
            ],
        ];

        $dataDoughNut_OrderTotal = [
            'labels' => array_keys($totalOrderCategories),
            'datasets' => [
                [
                    'backgroundColor' => [
                        '#3498db', '#2ecc71', '#e74c3c', '#f1c40f', '#9b59b6', '#2980b9', '#27ae60', '#c0392b', '#f39c12', '#8e44ad'
                    ],
                    'borderColor' => [
                        '#3498db', '#2ecc71', '#e74c3c', '#f1c40f', '#9b59b6', '#2980b9', '#27ae60', '#c0392b', '#f39c12', '#8e44ad'
                    ],
                    'data' => array_values($totalOrderCategories),
                ],
            ],
        ];

        return view('admin.dashboard', [
            'count_users' => $count_users,
            'count_posts' => $count_posts,
            'count_products' => $count_products,
            'count_categories' => $count_categories,
            'categories' => $categories,
            'dataBar_Revenue' => $dataBar_Revenue,
            'dataDoughNut_OrderTotal' => $dataDoughNut_OrderTotal,
            'year' => $yearNow
        ]);
    }

    private function calculateTotalOrder($category)
    {
        $total = $category->total_order;

        if ($category->children->isNotEmpty()) {
            foreach ($category->children as $childCategory) {
                $total += $this->calculateTotalOrder($childCategory);
            }
        }

        return $total;
    }

}
