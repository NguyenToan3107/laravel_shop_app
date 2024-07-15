<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'order';

    protected $dates = [
        'updated_at',
    ];

    protected $fillable = ['id', 'idkey', 'shop_id', 'module', 'locale', 'payment_type', 'request_id', 'gate_id',
        'bank_id', 'title', 'description', 'content', 'author_id', 'price_input', 'price_input', 'price_base',
        'price', 'price_old', 'ratio', 'percent_sale', 'real_received_price', 'price_ctv', 'ratio_ctv', 'real_received_price_ctv',
        'ratio_exchange_rate', 'additional_amount', 'params', 'tranid', 'ref_id', 'order', 'sticky', 'processor_id',
        'expired_lock', 'position', 'response_code', 'response_mess', 'status', 'request_id_customer',
        'request_id_provider', 'process_at', 'recheck_at', 'type_version', 'recheck_count', 'created_at', 'updated_at',
        'ended_at', 'paided_at', 'deleted_at', 'acc_id', 'value_gif_bonus', 'fullname', 'phone', 'address',
        'order_type', 'guarantee', 'handle_shop_id', 'user_hold_id', 'user_handle_id'];

    public function orderDetails() {
        return $this->hasMany(OrderDetail::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'author_id')->select(['id', 'email']);
    }
}
