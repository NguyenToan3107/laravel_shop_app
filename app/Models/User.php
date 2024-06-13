<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Traits\HasRoles;

class User extends Model
{
    use HasFactory;
    use HasRoles;
    protected $table = 'users';
    protected $fillable = ['id', 'name', 'email', 'password', 'status', 'age', 'phoneNumber', 'address', 'role', 'image_path'];
    protected $hidden = ['password'];

    public function posts() {
        return $this->hasMany(Post::class);
    }
}
