<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Setting extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'settings';
    protected $fillable = ['id', 'key', 'value', 'status', 'description', 'created_at', 'updated_at', 'deleted_at'];
}
