<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product_Attribute_Set extends Model
{
    use HasFactory;
    protected $table = 'product_attribute_set';
    protected $fillable = ['id', 'name', 'created_at', 'updated_at', 'deleted_at'];

    public function products()
    {
        return $this->hasMany(Product::class, 'product_attribute_set_id', 'id');
    }

    public function attributes() {
        return $this->belongsToMany(
            Product_Attribute::class,
            'product_attribute_set_attribute',
            'attribute_set_id',
            'attribute_id'
        );
    }
}
