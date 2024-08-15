<?php

namespace App\Models;


use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
//class User extends Model
{
    use HasFactory;
    use HasRoles;
    use SoftDeletes;

    protected $table = 'users';
    protected $fillable = ['id', 'name', 'email', 'password', 'status', 'age', 'phoneNumber', 'address', 'role',
        'image_path', 'deleted_at', 'created_at', 'updated_at', 'provider_id', 'provider'];
    protected $hidden = ['password'];

    public function posts()
    {
        return $this->hasMany(Post::class);
    }
    public function orders() {
        return $this->hasMany(Order::class);
    }
    public function orderDetails() {
        return $this->hasMany(OrderDetail::class);
    }
}
