<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product_Attribute extends Model
{
    use HasFactory;
    protected $table = 'product_attribute';
    protected $fillable = ['id', 'name', 'created_at', 'updated_at', 'deleted_at'];

    public function attributeValues()
    {
        return $this->hasMany(Product_Attribute_Value::class, 'attribute_id', 'id')->select('id', 'value');
    }
    public function product_attribute_sets() {
        return $this->belongsToMany(
            Product_Attribute_Set::class,
            'product_attribute_set_attribute',
            'attribute_id',
            'attribute_set_id'
        );
    }
}
