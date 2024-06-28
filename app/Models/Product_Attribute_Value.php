<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product_Attribute_Value extends Model
{
    use HasFactory;
    protected $table = 'product_attribute_value';
    protected $fillable = ['id', 'attribute_id', 'value', 'created_at', 'updated_at', 'deleted_at'];

    public function attribute() {
        return $this->belongsTo(Product_Attribute::class, 'attribute_id');
    }

    public function skus()
    {
        return $this->belongsToMany(Product_Sku::class,
            'product_attribute_value_sku', 'attribute_value_id', 'sku_id');
    }
}
