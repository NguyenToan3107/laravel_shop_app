<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product_Sku extends Model
{
    use HasFactory;
    protected $table = 'product_skus';
    protected $fillable = ['id', 'product_id', 'sku', 'price', 'price_old', 'quantity',
        'percent_sale', 'created_at', 'updated_at', 'deleted_at'];

    public function attributeValues() {
        return $this->belongsToMany(Product_Attribute_Value::class,
            'product_skus_attribute_value', 'sku_id', 'attribute_value_id');
    }
    public function product() {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }
}
