<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Setting extends Model
{
    use HasFactory;

    protected $table = 'settings';
    protected $fillable = ['id', 'name', 'val', 'type', 'created_at', 'updated_at', 'shop_id', 'desc', 'locale'];
}
