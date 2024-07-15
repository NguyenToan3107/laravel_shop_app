<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Scout\Searchable;

class Product extends Model
{
    use HasFactory, Searchable;
    use Sluggable;
    use SoftDeletes;
    protected $table = 'products';
    protected $primaryKey = 'id';
    protected $fillable = ['id', 'idkey', 'shop_id','module', 'locale', 'parent_id', 'title', 'slug', 'is_slug_override', 'duplicate', 'description',
        'content', 'image', 'image_extension', 'image_banner', 'image_icon', 'url', 'url_type', 'author_id', 'target', 'price', 'price_old', 'params',
        'params_plus', 'total_item', 'total_view', 'total_order', 'order', 'providers_id', 'position', 'display_type', 'sticky', 'is_display',
        'seo_title', 'seo_description', 'seo_robots', 'status', 'account_fake', 'started_at', 'ended_at', 'published_at', 'created_at', 'percent_sale',
        'updated_at', 'deleted_at', 'category_id', 'product_attribute_set_id'];

    public $timestamps = true;

    public function categories()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
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


    public function searchableAs()
    {
        return 'products_index';
    }

    public function toSearchableArray()
    {
        // Trả về một mảng chỉ chứa trường 'title'
        return [
            'title' => $this->title,
        ];
    }

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }
}
