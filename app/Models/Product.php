<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $table = 'products';
    protected $primaryKey = 'id';
    protected $fillable = ['id', 'idkey', 'shop_id','module', 'locale', 'parent_id', 'title', 'slug', 'is_slug_override', 'duplicate', 'description',
        'content', 'image', 'image_extension', 'image_banner', 'image_icon', 'url', 'url_type', 'author_id', 'target', 'price', 'params',
        'params_plus', 'total_item', 'total_view', 'total_order', 'order', 'providers_id', 'position', 'display_type', 'sticky', 'is_display',
        'seo_title', 'seo_description', 'seo_robots', 'status', 'account_fake', 'started_at', 'ended_at', 'published_at', 'created_at',
        'updated_at', 'deleted_at', 'category_id', 'product_attribute_set_id'];

    public $timestamps = true;

    public function categories()
    {
        return $this->belongsTo(Category::class);
    }

    public function children() {
        return $this->hasMany(Product::class, 'parent_id', 'id');
    }

    public function product_images() {
        return $this->hasMany(Product_Image::class, 'product_id', 'id')
            ->select('id', 'product_id', 'image_url');
    }

    public function skus()
    {
        return $this->hasMany(Product_Sku::class, 'product_id', 'id');
    }

    public function product_attribute_set() {
        return $this->belongsTo(Product_Attribute_Set::class, 'product_attribute_set_id', 'id');
    }

}
