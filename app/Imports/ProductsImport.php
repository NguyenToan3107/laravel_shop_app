<?php

namespace App\Imports;

use App\Models\Product;
use App\Models\Product_Image;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ProductsImport implements ToCollection, WithHeadingRow
{
    /**
     * @param Collection $collection
     */
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
//            dd($row->keys()->toArray());
            $product = Product::where('title', $row['ten_san_pham'])->first();
            if ($product) {
                $product->update([
                    'price' => $row['gia_ban'],
                    'price_old' => $row['gia_goc'],
                    'image' => $row['anh'],
                    'category_id' => $row['danh_muc'],
                    'status' => 1,
                    'product_attribute_set_id' => $row['bo_thuoc_tinh'],
                    'percent_sale' => $row['khuyen_mai'],
                ]);
            } else {
                $product = Product::create([
                    'title' => $row['ten_san_pham'],
                    'price' => $row['gia_ban'],
                    'price_old' => $row['gia_goc'],
                    'image' => $row['anh'],
                    'category_id' => $row['danh_muc'],
                    'status' => 1,
                    'product_attribute_set_id' => $row['bo_thuoc_tinh'],
                    'percent_sale' => $row['khuyen_mai'],
                ]);

                for ($i = 1; $i < 4; $i++) {
                    Product_Image::create([
                        'product_id' => $product->id,
                        'image_url' => '/storage/photos/products/empty-photo.jpg',
                    ]);
                }
            }
        }
    }
}
