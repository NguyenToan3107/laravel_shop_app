<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product_Skus_Attribute_Value extends Model
{
    use HasFactory;
    protected $table = 'product_skus_attribute_value';
    protected $fillable = ['skus_id', 'attribute_value_id'];
}
