<?php

namespace App\Models;


use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Role;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
//class User extends Model
{
    use HasFactory;
    use HasRoles;
    protected $table = 'users';
    protected $fillable = ['id', 'name', 'email', 'password', 'status', 'age', 'phoneNumber', 'address', 'role', 'image_path', 'deleted_at', 'created_at', 'updated_at'];
    protected $hidden = ['password'];

    public function posts() {
        return $this->hasMany(Post::class);
    }
}
