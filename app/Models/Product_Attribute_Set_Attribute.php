<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product_Attribute_Set_Attribute extends Model
{
    use HasFactory;
    protected $table = 'product_attribute_set_attribute';
    protected $fillable = ['attribute_set_id', 'attribute_id'];
}
