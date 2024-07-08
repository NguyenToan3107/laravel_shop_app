<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Staudenmeir\LaravelAdjacencyList\Eloquent\HasRecursiveRelationships;

class Category extends Model
{
    use HasFactory;
    use HasRecursiveRelationships;
    use Sluggable;

    protected $table = 'categories';
    protected $primaryKey = 'id';

    protected $fillable = ['id', 'idkey', 'shop_id','module', 'locale', 'parent_id', 'title', 'slug', 'is_slug_override', 'duplicate', 'description',
        'content', 'image', 'image_extension', 'image_banner', 'image_icon', 'url', 'url_type', 'author_id', 'target', 'price', 'params',
        'params_plus', 'total_item', 'total_view', 'total_order', 'order', 'providers_id', 'position', 'display_type', 'sticky', 'is_display',
        'seo_title', 'seo_description', 'seo_robots', 'status', 'account_fake', 'started_at', 'ended_at', 'published_at', 'created_at',
        'updated_at', 'deleted_at'];

    public function products()
    {
        return $this->hasMany(Product::class);
    }
    public function children()
    {
        return $this->hasMany(Category::class,'parent_id');
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
