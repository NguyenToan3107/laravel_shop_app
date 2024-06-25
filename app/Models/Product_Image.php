<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product_Image extends Model
{
    use HasFactory;
    protected $table = 'product_image';
    protected $fillable = ['id', 'product_id', 'image_url', 'created_at', 'updated_at', 'deleted_at'];

    public function product() {
        return $this->belongsTo(Product::class);
    }
}
