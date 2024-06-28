<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product_Attribute extends Model
{
    use HasFactory;
    protected $table = 'product_attribute';
    protected $fillable = ['id', 'name', 'created_at', 'updated_at', 'deleted_at', 'product_attribute_set_id'];

    public function attributeValues()
    {
        return $this->hasMany(Product_Attribute_Value::class);
    }
    public function product_attribute_set() {
        return $this->belongsTo(Product_Attribute_Set::class, 'product_attribute_set_id', 'id');
    }
}
