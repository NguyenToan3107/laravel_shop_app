<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product_Attribute extends Model
{
    use HasFactory;
    protected $table = 'product_attribute';
    protected $fillable = ['product_id', 'id', 'capacity', 'price', 'percent_sale', 'price_old', 'color'];

    public function product() {
        return $this->belongsTo(Product::class);
    }
}
