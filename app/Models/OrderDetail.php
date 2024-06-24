<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    use HasFactory;

    protected $table = 'order_detail';

    protected $fillable = ['id', 'idkey', 'title', 'description', 'content', 'shop_id', 'module', 'order_id', 'item_id',
        'quantity', 'unit_price', 'unit_price_ctv', 'discount_percentage', 'discount_price', 'author_id', 'status',
        'created_at', 'updated_at', 'ended_at', 'deleted_at'];

    public function products() {
        return $this->belongsTo(Product::class, 'item_id')
            ->select('id', 'title', 'price', 'image', 'percent_sale');
    }

    public function order() {
        return $this->belongsTo(Order::class, 'order_id')
            ->select('id', 'fullname', 'phone', 'address');
    }

    public function user() {
        return $this->belongsTo(User::class, 'author_id')
            ->select('id', 'name', 'email');
    }

}
